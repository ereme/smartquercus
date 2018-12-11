<?php

namespace App\Controller;

use App\Entity\User;


use App\Controller\UserType;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;
use App\Entity\Imagen;
use App\Form\ImagenType;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', ['users' => $userRepository->findAll()]);
    }


    /**
     * @Route("/{id}", name="user_show", methods="GET" , requirements={"id"="\d+"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function edit(Request $request, User $user): Response
    {
       

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->files->get('user')['fichero'] != nulll){

            $fichero = $request->files->get('user')['fichero'];

            $nombre_antiguo_borrar = $user->getImagen()->getNombre();
            $nombre_antiguo = $user->getImagen()->getOriginal();
            $nombre_nuevo = $fichero->getClientOriginalName();
            $tamano_antiguo = $user->getImagen()->getSize();
            $tamano_nuevo = $fichero->getSize();

                if (($nombre_nuevo != $nombre_antiguo) || ($tamano_nuevo != $tamano_antiguo)){
                    $fileName = md5(uniqid());
                    
                    $imagen = new Imagen();
                    $imagen->setNombre($fileName);
                    $imagen->setOriginal($nombre_nuevo));
                    $imagen->setSize($tamano_nuevo);
                
                //Base de datos

                    $em->remove($user->getImagen());
                    $user->setImagen($imagen);


                // Disco duro

                    unlink($this->getParameter('carpeta_imagenes') ."/". $nombre_antiguo_borrar);

                try {
                    $fichero->move(
                        $this->getParameter('carpeta_imagenes'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

            }

        }

        $em->persist($user);
        $em->flush();
        $this->getDoctrine()->getManager()->flush();
        

        return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }
 
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
