<?php

namespace App\Controller;

use App\Entity\Opina;
use App\Entity\Ayuntamiento;
use App\Entity\Imagen;
use App\Entity\Admin;
use App\Form\OpinaType;
use App\Repository\OpinaRepository;
use App\Repository\VecinoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/opina")
 */
class OpinaController extends AbstractController
{
    /**
     * @Route("/", name="opina_index", methods="GET")
     */
    public function index(OpinaRepository $opinaRepository): Response
    {

        $opinas = array();
        if ($this->isGranted('ROLE_ADMIN')) { //soy admin
         $opina = $opinaRepository->findAll();
        }
        elseif ($this->isGranted('ROLE_AYTO')) { //soy ayto
            $opinas = $this->getUser()->getEncuestas();
        } elseif ($this->isGranted('ROLE_VECINO')) { //soy vecino
            $opinas = $this->getUser()->getAyuntamiento()->getEncuestas();
        }

        return $this->render('opina/index.html.twig', [
            'opinas' => $opinas
        ]);
    }

    /**
     * @Route("/new", name="opina_new", methods="GET|POST")
     * @Security("has_role('ROLE_AYTO')")
     */
    public function new(Request $request): Response
    {
        $opina = new Opina();
        $opina->setAyuntamiento($this->getUser());
        $form = $this->createForm(OpinaType::class, $opina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->files->get('opina')['fichero'] != null){
                $fichero = $request->files->get('opina')['fichero'];
                $fileName = md5(uniqid());

                $imagen = new Imagen();
                $imagen->setNombre($fileName);
                $imagen->setOriginal($fichero->getClientOriginalName());
                $opina->setImagen($imagen);
                $imagen->setSize($fichero->getSize());

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

            }
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($opina);
            $em->flush();

            return $this->redirectToRoute('opina_index');
        }

        return $this->render('opina/new.html.twig', [
            'opina' => $opina,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/{id}", name="opina_show", methods="GET")
    * @Security("has_role('ROLE_AYTO')")
    */
    public function show(Opina $opina): Response
    {
        return $this->render('opina/show.html.twig', ['opina' => $opina]);
    }

    /**
     * @Route("/{id}/edit", name="opina_edit", methods="GET|POST")
     * @Security("has_role('ROLE_AYTO')")
     */
    
    public function edit(Request $request, Opina $opina): Response
    {
        $form = $this->createForm(OpinaType::class, $opina);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->files->get('opina')['fichero'] != null){
                $fichero = $request->files->get('opina')['fichero'];

                $nombre_antiguo_borrar = $opina->getImagen()->getNombre();
                $nombre_antiguo = $opina->getImagen()->getOriginal();
                $nombre_nuevo = $fichero->getClientOriginalName();
                $tamano_antiguo = $opina->getImagen()->getSize();
                $tamano_nuevo = $fichero->getSize();




                if (($nombre_nuevo != $nombre_antiguo) || ($tamano_nuevo != $tamano_antiguo)){
                    $fileName = md5(uniqid());

                    $imagen = new Imagen();
                    $imagen->setNombre($fileName);
                    $imagen->setOriginal($nombre_nuevo);
                    $imagen->setSize($tamano_nuevo);


                    //Base de datos -> lo borra de la base de datos

                    $em->remove($opina->getImagen());
                    $opina->setImagen($imagen);


                    //Disco duro -> lo borra del disco duro
                    unlink($this->getParameter('carpeta_imagenes') ."/". $nombre_antiguo_borrar);
                    try{
                        $fichero->move(
                            $this->getParameter('carpeta_imagenes'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        // ...handle exception if something happens during file upload 
                    }
                }
            }


            $em->persist($opina);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();            

            return $this->redirectToRoute('opina_index');
        }

        return $this->render('opina/edit.html.twig', [
            'opina' => $opina,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="opina_delete", methods="DELETE")
     * @Security("has_role('ROLE_AYTO')")
     */
    public function delete(Request $request, Opina $opina): Response
    {
        if ($this->isCsrfTokenValid('delete'.$opina->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($opina);
            $em->flush();
        }

        return $this->redirectToRoute('opina_index');
    }

    /**
     * @Route("/{idopina}/{idvecino}/{valor}/json", name="opina_json", requirements={"idopina"="\d+","idvecino"="\d+" })
     */
    public function jsonOpina($idopina, $idvecino, $valor, Request $request, VecinoRepository $vecinoRepo)
    {

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y H:i')
                : '';
        };
        $callback2 = function ($imagen) {
            if ($imagen != null) {
                /*return $imagen->getCreatedAt() instanceof \DateTime
                    ? $imagen->getCreatedAt()->format('d-m-Y H:i')
                    : '';
                    */
                    return $this->getParameter('carpeta_imagenes') . "/" . $imagen->getNombre();
            } else {
                return null;
            }
        };

        $normalizer->setCallbacks(array('fechahoralimite' => $callback,
                                        'imagen' => $callback2,
                                        ));

/*
        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y')
                : '';
        };
        $callback2 = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y')
                : '';
        };

        $normalizer->setCallbacks(array('fechahoralimite' => $callback));
        $normalizer->setCallbacks(array('createdAt' => $callback2));*/

        $normalizer->setCircularReferenceHandler(
            function ($object) {
                return $object->getId();
            }
        );
        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));


        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Opina::class);
        $opina = $repo->find($idopina);

        dump ($opina);

        if ($valor == 'C') {
            $opina->subirVotosContra();
        } elseif ($valor == 'F') {
            $opina->subirVotosFavor();
        }

        $vecino = $vecinoRepo->find($idvecino);
        $opina->addVecino($vecino);
        $em->persist($opina);
        $em->flush();

        $jsonMensaje = $serializer->serialize($opina, 'json');      
        $respuesta = new Response($jsonMensaje);       
        return $respuesta;
    }

    /**
     * @Route("/opina/json/{ayto}", name="json_opina")
     */
    public function opinaJson($ayto)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y H:i')
                : '';
        };

        $normalizer->setCallbacks(array('fechahoralimite' => $callback,
            'createdAt' => $callback
        ));

        $normalizer->SetCircularReferenceHandler(function ($object){
            return $object->getId();
        });
        $normalizer->setCircularReferenceLimit(0);

        $serializer = new Serializer(array($normalizer), array($encoder));

        $repo = $this->getDoctrine()->getRepository(Opina::class);
        $opina = $repo->findByAyto($ayto); 

        $jsonMensaje = $serializer->serialize($opina, 'json');   
        $respuesta = new Response($jsonMensaje);    
        return $respuesta;
    }
    
}
