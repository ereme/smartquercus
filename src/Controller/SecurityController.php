<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vecino;
use App\Entity\Ayuntamiento;
use App\Entity\Admin;
use App\Form\UserType;
use App\Form\VecinoType;
use App\Form\AyuntamientoType;
use App\Form\AdminType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login", methods="GET|POST")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils, Security $security)
    {    
        // Aquí ya se ha producido el login y recoge en la siguiente línea los errores que puedan haberse producido
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Recoge el último username introducido por el usuario (tanto si ha habido errores como si ha sido OK el login)
        $lastUsername = $authenticationUtils->getLastUsername();
        dump ($error);

        // Renderiza la plantilla con dos parámetros: last_username y error (por si ha fallado el login y tiene que mostrar un error de autenticación)

        dump ($security->getUser());
        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        //$user = new User();
        //$form = $this->createForm(UserType::class, $user);

        $tipo = $request->query->get('tipo');
        if ($tipo == Ayuntamiento::USER_AYTO) {
            $user = new Ayuntamiento();
            $form = $this->createForm(AyuntamientoType::class, $user);
        } else if($tipo == Vecino::USER_VECINO){
            $user = new Vecino();
            $form = $this->createForm(VecinoType::class, $user);
        } else {
            $user = new Admin();
            $form = $this->createForm(AdminType::class,$user);
        }

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        dump ($form);
        dump ($request);
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }
}