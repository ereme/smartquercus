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
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichero = $request->files->get('imagen')['fichero'];
            $fileName = md5(uniqid());
            
            /*dump ($imagen);
            dump ($fichero);
            dump ($user);
            dump ($request->files);*/
            $imagen->setNombre($fileName);
            $imagen->setOriginal($fichero->getClientOriginalName());
            $user->setImagen($imagen);
            
            /*dump ($imagen);

            dump ($fichero);
            dump ($salud);*/

            // Move the file to the directory where brochures are stored
            try {
                $fichero->move(
                    $this->getParameter('carpeta_imagenes'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
 
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
