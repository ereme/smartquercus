<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Form\AdminType;
use App\Form\VecinoType;
use App\Form\AyuntamientoType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//use Symfony\Component\Security\Core\Security;
use App\Entity\Imagen;
use App\Form\ImagenType;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/user")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class UserController extends AbstractController
{

   /**
     * @Route("/email", name="user_email", methods="GET")
     */
    public function email(\Swift_Mailer $mailer)
    {
        $name = 'Jesus';
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('ddiazp04@gmail.com')
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
        
        dump ($mailer);
        $mailer->send($message);

        return $this->render('user/index.html.twig');
    }


    /**
     * @Route("/", name="user_index", methods="GET")
     * @Security("has_role('ROLE_AYTO')")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', ['users' => $userRepository->findAll()]);
    }


    /**
     * @Route("/profile", name="user_profile", methods="GET")
     */
    public function profile(): Response
    {
        return $this->render('user/show.html.twig', ['user' => $this->getUser()]);
    }


    /**
     * @Route("/{id}", name="user_show", methods="GET" , requirements={"id"="\d+"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }


    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function edit(Request $request, User $user): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) { //soy ayto
            $clase = AdminType::class;
            $tipo = 'admin';
        } else { //no se permite carga de perfil de otros usuarios, redirect al perfil del current user
            if ($user != $this->getUser()) {
                return $this->redirectToRoute('user_edit', array('id' => $this->getUser()->getId()));
            }
            $user = $this->getUser();
            if ($this->isGranted('ROLE_AYTO')) { //soy ayto
                $clase = AyuntamientoType::class;
                $tipo = 'ayuntamiento';
            } else { //soy vecino
                $clase = VecinoType::class;
                $tipo = 'vecino';
            }
        }



        $form = $this->createForm($clase, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            dump ($request->files->get($tipo)['fichero'] != null );
            if ($request->files->get($tipo)['fichero'] != null ){

                $fichero = $request->files->get($tipo)['fichero'];
                $nombre_nuevo = $fichero->getClientOriginalName();
                $tamano_nuevo = $fichero->getSize();

                if ($user->getImagen() != null) {
                    $nombre_antiguo_borrar = $user->getImagen()->getNombre();
                    $nombre_antiguo = $user->getImagen()->getOriginal();
                    $tamano_antiguo = $user->getImagen()->getSize();                    
                } else {
                    $nombre_antiguo = $nombre_antiguo_borrar = '';
                    $tamano_antiguo = 0;
                }

                if (($nombre_nuevo != $nombre_antiguo) || ($tamano_nuevo != $tamano_antiguo)){

                    $fileName = md5(uniqid());
                    
                    $imagen = new Imagen();
                    $imagen->setNombre($fileName);
                    $imagen->setOriginal($nombre_nuevo);
                    $imagen->setSize($tamano_nuevo);
                    
                    dump ($imagen);
                    if ($user->getImagen() != null) { //SI TENIA IMAGEN...
                        $this->getDoctrine()->getManager()->remove($user->getImagen()); //borro imagen en bd                  
                        unlink($this->getParameter('carpeta_imagenes') ."/". $nombre_antiguo_borrar); //borro imagen disco
                    }

                    $user->setImagen($imagen); 
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }
 
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     * @Security("has_role('ROLE_ADMIN')")
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
