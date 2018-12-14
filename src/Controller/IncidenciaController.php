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

/**
 * @Route("/incidencia")
 */
class IncidenciaController extends AbstractController
{
    /**
     * @Route("/", name="incidencia_index", methods="GET")
     */
    public function index(IncidenciaRepository $incidenciaRepository, AuthorizationCheckerInterface $authChecker): Response
    {
        if ($this->isGranted(Vecino::USER_VECINO) ) {
            $ayuntamiento = $this->getAyuntamiento();
            $incidencias = $ayuntamiento->getIncidencias(); 
            return $this->render('incidencia/index.html.twig', 
            ['incidencias' => $incidencias->findAll()]);
        }elseif ($this->isGranted(Ayuntamiento::USER_AYTO)) {
            $incidencias = $this->getIncidencias();
            return $this->render('incidencia/index.html.twig', ['incidencias' => $incidencias->findAll()]);
        }elseif ($this->isGranted(Admin::USER_ADMIN)) {
            return $this->render('incidencia/index.html.twig', ['incidencias' => $incidenciaRepository->findAll()]);
        }
        

        return $this->render('incidencia/index.html.twig', ['incidencias' => $incidenciaRepository->findAll()]);
    }

    /**
     * @Route("/new", name="incidencia_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $usuario = $this->getUser();
        $ayuntamiento = $usuario->getAyuntamiento();
        $incidencium = new Incidencia();
        $form = $this->createForm(IncidenciaType::class, $incidencium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->files->get('incidencium')['fichero'] != null) {
                
                
                $fichero = $request->files->get('incudencium')['fichero'];
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
            $incidencium->setAyuntamiento($ayuntamiento);
            //$ayuntamiento->addIncidencia($incidencium);
            $em = $this->getDoctrine()->getManager();
            $em->persist($incidencium);
            $em->flush();

            return $this->redirectToRoute('incidencia_index');
        }

        return $this->render('incidencia/new.html.twig', [
            'incidencium' => $incidencium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="incidencia", methods="GET", requirements={"id"="\d+"})
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
     */
    public function edit(Request $request, Incidencia $incidencia): Response
    {
        $form = $this->createForm(IncidenciaType::class, $incidencia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        
            return $this->redirectToRoute('incidencia_edit', ['id' => $incidencia->getId()]);
        }

        return $this->render('incidencia/edit.html.twig', [
            'incidencia' => $incidencia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="incidencia_delete", methods="DELETE")
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
     * @Route("/json", name="json_incidencia")
     */
    public function incidenciasJson()
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $callback = function ($date) {
            return $date instanceof \Date
                ? $date->format('d-m-Y ')
                : '';
        };

        $normalizer->setCallbacks(array('fecha' => $callback));
        
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) { return $object->getId(); });
        $serializer = new Serializer(array($normalizer), array($encoder));

        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Incidencia::class);
        $incidencias= $repo->findAllOrdenados();

        $jsonIncidencias = $serializer->serialize($incidencias, 'json');      
        $respuesta = new Response($jsonIncidencias);       
        return $respuesta;
    }
    
}
