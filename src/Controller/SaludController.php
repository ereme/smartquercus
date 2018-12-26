<?php

namespace App\Controller;

use App\Entity\Salud;
use App\Entity\Imagen;
use App\Form\SaludType;
use App\Repository\SaludRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/salud")
 */
class SaludController extends AbstractController
{
    /**
     * @Route("/", name="salud_index", methods="GET")
     */
    public function index(SaludRepository $saludRepository): Response
    {
        return $this->render('salud/index.html.twig', [
            'saluds' => $saludRepository->findAll()]);
    }

    /**
     * @Route("/new", name="salud_new", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $salud = new Salud();
        $form = $this->createForm(SaludType::class, $salud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->files->get('salud')['fichero'] != null) {               
                
                $fichero = $request->files->get('salud')['fichero'];
                $fileName = md5(uniqid());
                
                $imagen = new Imagen();
                $imagen->setNombre($fileName);
                $imagen->setOriginal($fichero->getClientOriginalName());
                $salud->setImagen($imagen);
                $imagen->setSize($fichero->getSize());

                // Move the file to the directory where brochures are stored
                try {
                    $fichero->move(
                        $this->getParameter('carpeta_imagenes'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
                 

            $em = $this->getDoctrine()->getManager();
            //$em->persist($imagen);  //si no está el cascadepersist en Salud entity
            $em->persist($salud); 
            $em->flush();
            die;
            return $this->redirectToRoute('salud_index');
        }

        return $this->render('salud/new.html.twig', [
            'salud' => $salud,

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salud_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(Salud $salud ): Response
    {
        return $this->render('salud/show.html.twig', ['salud' => $salud]);
    }

    /**
     * @Route("/{id}/edit", name="salud_edit", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Salud $salud): Response
    {
        $form = $this->createForm(SaludType::class, $salud);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->files->get('salud')['fichero'] != null) {
                $fichero = $request->files->get('salud')['fichero'];

                $nombre_antiguo_borrar = $salud->getImagen()->getNombre();
                $nombre_antiguo = $salud->getImagen()->getOriginal(); 
                $nombre_nuevo = $fichero->getClientOriginalName();
                $tamano_antiguo = $salud->getImagen()->getSize();
                $tamano_nuevo = $fichero->getSize();

                dump ($nombre_antiguo);
                dump ($nombre_nuevo);
                dump ($tamano_antiguo);
                dump ($tamano_nuevo);


                
                if (($nombre_nuevo != $nombre_antiguo) || ($tamano_nuevo != $tamano_antiguo)) {
                    $fileName = md5(uniqid());
                    
                    $imagen = new Imagen();
                    $imagen->setNombre($fileName);
                    $imagen->setOriginal($nombre_nuevo);
                    $imagen->setSize($tamano_nuevo);
                    
                    //Base de datos
                    $em->remove($salud->getImagen());
                    $salud->setImagen($imagen);

                    //Disco duro
                   /* dump ($this->getParameter('carpeta_imagenes') ."/". $nombre_antiguo_borrar); */
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

            $em->persist($salud);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();       

            return $this->redirectToRoute('salud_show', ['id' => $salud->getId()]);
        }

        return $this->render('salud/edit.html.twig', [
            'salud' => $salud,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salud_delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Salud $salud): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salud->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salud);
            $em->flush();
        }

        return $this->redirectToRoute('salud_index');
    }

    /** 
     * @Route("/json", name="json_salud")
     */
    public function jsonSalud()
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y')
                : '';
        };

        $normalizer->setCallbacks(array('fechahora' => $callback,
            'createdAt' => $callback
        ));

        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));

        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Salud::class);
        $opina = $repo->findAllOrdenados();

        $jsonMensaje = $serializer->serialize($opina, 'json');      
        $respuesta = new Response($jsonMensaje);   
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->headers->set('Access-Control-Allow-Origin', '*');    
        return $respuesta;
    }
}
