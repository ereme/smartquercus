<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Vecino;
use App\Entity\Imagen;
use App\Entity\Ayuntamiento;
use App\Entity\Incidencia;
use App\Form\IncidenciaType;
use App\Repository\IncidenciaRepository;
use App\Repository\AyuntamientoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/incidencia")
 */
class IncidenciaController extends AbstractController
{
    /**
     * @Route("/", name="incidencia")
     */
    public function index(IncidenciaRepository $incidenciaRepository, AuthorizationCheckerInterface $authChecker):Response
    {
        $usuario = $this->getUser();
        $roles = $usuario->getRoles();

        if ($roles[0] == 'ROLE_VECINO'  ) {
            $ayuntamiento = $usuario->getAyuntamiento();
            $aytoid = $ayuntamiento->getId();
            $incidencias = $ayuntamiento->getIncidencias(); 
            return $this->render('incidencia/index.html.twig', 
            ['incidencias' => $incidenciaRepository->findById($aytoid)]);

        }elseif ($roles[0] == 'ROLE_AYTO' ) {
            $incidencias = $usuario->getIncidencias();
            $aytoid = $usuario->getId();
            return $this->render('incidencia/index.html.twig', ['incidencias' => $incidenciaRepository->findById($aytoid)]);

        }elseif ($roles[0] == 'ROLE_ADMIN' ) {
            return $this->render('incidencia/index.html.twig', ['incidencias' => $incidenciaRepository->findAll()]);
        }
       
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/new", name="incidencia_new", methods="GET|POST")
     * @Security("has_role('ROLE_VECINO')")
     */
    public function new(Request $request)
    {
        $usuario = $this->getUser();
        $ayuntamiento = $usuario->getAyuntamiento();
        $incidencia = new Incidencia();
        $form = $this->createForm(IncidenciaType::class, $incidencia);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
    
            $ficheros = $request->files->get('incidencia')['ficheros'];

            
            foreach ($ficheros as $fichero) {
                
               
                $fileName = md5(uniqid());

                $imagen = new Imagen();
                $imagen->setNombre($fileName);
                $imagen->setOriginal($fichero->getClientOriginalName());
                $imagen->setSize($fichero->getSize());
                $incidencia->addImagene($imagen);
                

                // Move the file to the directory where brochures are stored
                try {
                    $fichero->move(
                        $this->getParameter('carpeta_imagenes'),$fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

            } 


            $incidencia->setAyuntamiento($ayuntamiento);
            dump ($incidencia);
            //$ayuntamiento->addIncidencia($incidencium);
            $em = $this->getDoctrine()->getManager();
            $em->persist($incidencia);
            $em->flush();

            return $this->redirectToRoute('incidencia');
        }

        return $this->render('incidencia/new.html.twig', [
            'incidencia' => $incidencia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="incidencia_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(Incidencia $incidencia, $id): Response
    {
        $incidencia = $this->getDoctrine()
        ->getRepository(Incidencia::class)
        ->find($id); 
        return $this->render('incidencia/show.html.twig', ['incidencia' => $incidencia]);
    }

    /**
     * @Route("/{id}/edit", name="incidencia_edit", methods="GET|POST")
     * @Security("has_role('ROLE_AYTO')")
     */
    public function edit(Request $request, Incidencia $incidencia): Response
    {
        $form = $this->createForm(IncidenciaType::class, $incidencia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        
            return $this->redirectToRoute('incidencia', ['id' => $incidencia->getId()]);
        }

        return $this->render('incidencia/edit.html.twig', [
            'incidencia' => $incidencia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="incidencia_delete", methods="DELETE")
     * @Security("has_role('ROLE_AYTO')")
     */
    public function delete(Request $request, Incidencia $incidencia): Response
    {
        if ($this->isCsrfTokenValid('delete'.$incidencia->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($incidencia);
            $em->flush();
        }

        return $this->redirectToRoute('incidencia_index');
    }
 
    /**
     * @Route("/json/{ayto}", name="json_incidencia")
     */
    public function incidenciasJson($ayto, Request $request)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $callback = function ($date) {
            return $date instanceof \Date
                ? $date->format('d-m-Y ')
                : '';
        };

        $callback2 = function ($ayto) {
            return $ayto->getLocalidad();
        };

        $callbackUrl = function ($images) use ($request) {
            $final = array();
            foreach ($images as $image) {
                $final[] = 'https://'
                    . $request->server->get('HTTP_HOST')
                    . '/images/'
                    . $image->getNombre();
            }
            return $final;
        };

        $normalizer->setCallbacks(array('fecha' => $callback,
                                        'createdAt' => $callback,
                                        'ayuntamiento' => $callback2,
                                        'imagenes' => $callbackUrl,
                                    ));
        
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) { return $object->getId(); });
        $serializer = new Serializer(array($normalizer), array($encoder));

        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Incidencia::class);
        $incidencias=  $repo->findBy(['ayuntamiento' => $ayto], ['fecha' => 'DESC']);

        $jsonIncidencias = $serializer->serialize($incidencias, 'json');      
        $respuesta = new Response($jsonIncidencias);       
        return $respuesta;
    }
    
    /**
     * @Route("/new/json", name="incidencia_new_json")
     */
    public function newJson (Request $request, AyuntamientoRepository $aytoRepo)
    {
        $content = $request->getContent();
        if (!empty($content)){
            $params = json_decode($content, true);
        }

        $incidencia = new Incidencia();
        $incidencia->setFecha(\DateTime::createFromFormat('d-m-Y', $params['fecha']));
        $incidencia->setLatitud($params['latitud']);
        $incidencia->setLongitud($params['longitud']);
        $incidencia->setDescripcion($params['descripcion']);

        $incidencia->setAyuntamiento($aytoRepo->find($params['aytoid']));
        $incidencia->setEstado($params['estado']);

        $fileName = md5(uniqid());
        //$data = explode(',', $params['imagen']); //si viene con la cabecera
        $data = $params['imagen']; //si viene sin la cabecera
        $path = $this->getParameter('carpeta_imagenes').'/'.$fileName;
        $imagenbase64 = base64_decode($data[1],$path);
        
        $imagen = new Imagen();
        $imagen->setNombre($fileName);
        //$imagen->setOriginal($imagenbase64->getClientOriginalName());
        $imagen->setSize(100); //CAMBIAR $imagenbase64->getSize()
        $imagen->setOriginal($fileName);
        $incidencia->addImagene($imagen);
/*
        try {
            $imagendecodificada->move($this->getParameter('carpeta_imagenes'),$fileName);
        } catch (FileException $e) {
        }
 */       
        $em = $this->getDoctrine()->getManager();
        $em->persist($incidencia);
        try {
            $em->flush();
        } catch (Exception $e) {
        }

        $vector = array('ok' => '');
        $codigo = 200; //ok
        
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


    function base64ToImage($base64_string, $output_file) {
        $file = fopen($output_file, "wb");
    
        $data = explode(',', $base64_string);
    
        fwrite($file, base64_decode($data[1]));
        fclose($file);
    
        return $output_file;
    }
}
