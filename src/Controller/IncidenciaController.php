<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Vecino;
use App\Entity\Imagen;
use App\Entity\Ayuntamiento;
use App\Entity\Incidencia;
use App\Form\IncidenciaType;
use App\Repository\IncidenciaRepository;
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
        dump($usuario);
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

        dump ($ayuntamiento);
        
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
    public function incidenciasJson($ayto)
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

        $normalizer->setCallbacks(array('fecha' => $callback, 'createdAt' => $callback, 'ayuntamiento' => $callback2));
        
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
    public function newJson (Request $request)
    {
        $params = array();
        $content = $request->getContent();
        if (!empty($content)){
            $params = json_decode($content, true);
        }

        $incidencia = new Incidencia();
        $incidencia->setFecha($params['fecha']);
        $incidencia->setLatitud($params['latitud']);
        $incidencia->setLongitud($params['longitud']);
        $incidencia->setDescripcion($params['descripcion']);
        $incidencia->setAyuntamiento($params['aytoid']);
        $incidencia->setEstado($params['estado']);

        $imagenbase64 = $params->get('imagen');
        $imagenbase64 = base64_decode($imagenbase64);
        $imagendecodificada = file_put_contents($params['userid'].'.'.$params->get('fecha'), $imagenbase64);

        $fileName = md5(uniqid());
        $imagen = new Imagen();
        $imagen->setNombre($fileName);
        $imagen->setOriginal($imagendecodificada->getClientOriginalName());
        $imagen->setSize($imagendecodificada->getSize());
        $incidencia->addImage($imagen);

        try {
            $imagendecodificada->move($this->getParameter('carpeta_imagenes'),$fileName);
        } catch (FileException $e) {
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($incidencia);
        try {
            $em->flush();
        } catch (Exception $e) {
        }
        
        $response = new Response(array('data' => 'ok'));


    }
}
