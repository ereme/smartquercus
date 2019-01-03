<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vecino;
use App\Entity\Ayuntamiento;
use App\Entity\Admin;
use App\Entity\Imagen;
use App\Form\UserType;
use App\Form\VecinoType;
use App\Form\AyuntamientoType;
use App\Form\AdminType;
use App\Repository\UserRepository;
use App\Repository\AyuntamientoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;





class SecurityController extends AbstractController
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

        //dump ($security->getUser());
        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    /**
     * @Route("/loginjson", name="loginjson", methods="GET|POST")
     */
    public function loginjson(Request $request)
    {    
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->SetCircularReferenceHandler(function ($object){
            return $object->getId();
        });
        $normalizer->setCircularReferenceLimit(0);

        $serializer = new Serializer(array($normalizer), array($encoder));

        $user = $this->getUser();
        $vector = array(
            'username' => $user->getUsername(),
            'aytoid' => $user->getAyuntamiento()->getId(),
            'userid' => $user->getId(),
            'roles' => $user->getRoles(),
        ); 
        
        $jsonMensaje = $serializer->serialize($vector, 'json');   

        $respuesta = new Response($jsonMensaje);    
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->headers->set('Access-Control-Allow-Origin', '*');
        
        return $respuesta;
    }


    /**
     * @Route("/registerjson", name="registerjson", methods="GET|POST")
     */
    public function registerjson(Request $request, AyuntamientoRepository $aytoRepo, 
                                    UserPasswordEncoderInterface $passwordEncoder)
    {    
        $codigo = '';
        try {

            $contenido = $request->getContent();
            $params = json_decode($contenido, true);

            $dni = $params['dni'];
            $nombre = $params['nombre'];
            $apellido1 = $params['apellido1'];
            $apellido2 = $params['apellido2'];
            $telefono = $params['telefono'];
            $email = $params['email'];
            $username = $params['username'];
            $password = $params['password'];
            $aytoid = $params['aytoid'];
            $ayto = $aytoRepo->find ($aytoid);
    
            
            $v = new Vecino();
            $v->setVatid($dni);
            $v->setNombre($nombre);
            $v->setApellido1($apellido1);
            $v->setApellido2($apellido2);
            $v->setTelefono($telefono);
            $v->setEmail($email);
            $v->setUsername($username);
            
            $v->setPassword($password);
            $password = $passwordEncoder->encodePassword($v, $password);
            $v->setPassword($password);
            $v->setAyuntamiento($ayto);
            
            
            //Persistencia
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($v);
            $entityManager->flush();

            
            $vector = array('ok' => '');
            $codigo = 200; //ok
        } catch (\Throwable $th) {
            $vector = array('error' => '');
            $codigo = 401; //error
        }


        //Codificación a JSON
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->SetCircularReferenceHandler(function ($object){
            return $object->getId();
        });
        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));

        $jsonMensaje = $serializer->serialize($vector, 'json');   

        $respuesta = new Response($jsonMensaje,$codigo);    
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->headers->set('Access-Control-Allow-Origin', '*');
        
        return $respuesta;
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
        } else if($tipo == Admin::USER_ADMIN){
            $user = new Admin();
            $form = $this->createForm(AdminType::class, $user);
        } else {
            $user = new Vecino();
            $form = $this->createForm(VecinoType::class,$user);
        }

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        /*dump ($form);
        dump ($request);*/
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            if ($request->files->get('ayuntamiento')['imagen'] != null) {
                if ($tipo == Ayuntamiento::USER_AYTO) {
                    $fichero = $request->files->get('ayuntamiento')['imagen'];
                    $fileName = md5(uniqid());
                    dump ($fichero);
                    $imagen = new Imagen();
                    $imagen->setNombre($fileName);
                    $imagen->setOriginal($fichero->getClientOriginalName());
                    $imagen->setSize($fichero->getSize());
                    dump ($imagen);
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


            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }
}