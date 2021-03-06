<?php

namespace DB\ServiceBundle\Controller;

use DB\ServiceBundle\Form\WebsiteType;
use DB\ServiceBundle\Entity\Website;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class WebsiteController extends FOSRestController {

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get a Website instance",
     *  output = "DB\ServiceBundle\Entity\Website",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the organisation is not found"
     *   }
     * )
     * 
     * Get Website instance
     * @param int $id Id of the Website
     * @return array Website
     * @throws NotFoundHttpException when Website not exist
     * 
     * @Rest\View()
     */
    public function getWebsiteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Website')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity');
        }
        return array('entity' => $entity);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get all Website instance",
     *  output = "DB\ServiceBundle\Entity\Website",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned  when Website table is empty"
     *   }
     * )
     * 
     * Get all Website instance
     * @param int $id Id of the Website
     * @return array Website
     * @throws NotFoundHttpException when Website table is empty
     * 
     * @return View()
     * 
     * @Rest\View()
     */
    public function getWebsitesAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DBServiceBundle:Website')->findAll();
        if (!$entities) {
            throw $this->createNotFoundException('No Website Entity found');
        }
        return array('entities' => $entities);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Delete a Website",
     *  statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Website is not found"
     *   }
     * )
     * Delete a Website
     * @param integer $id Id of the entity
     * @return View
     * @throws NotFoundHttpException when Website not exist
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteWebsiteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Website')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity');
        }
        $em->remove($entity);
        $em->flush();
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Put a Website instance",
     *  output = "DB\ServiceBundle\Entity\Website",
     *  statusCodes = {
     *     200 = "Returned when the request success",
     *     204 = "Returned when the request fail",
     *     404 = "Returned when the entity not exist"
     *   }
     * )
     * 
     * Put action
     * @param Request $request
     * @param integer $id Id of the entity
     * @return View|array
     * @throws NotFoundHttpException when Website not exist
     * 
     * @Rest\View(template="DBServiceBundle:Website:getWebsite.html.twig")
     */
    public function putWebsiteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Website')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity');
        }
        $form = $this->createForm(new WebsiteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return array('entity' => $entity,);
        }
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="post a Website instance",
     *  output = "DB\ServiceBundle\Entity\Website",
     *  statusCodes = {
     *     200 = "Returned when the request success",
     *     204 = "Returned when the request fail",
     *   }
     * )
     * 
     * Post action
     * @param Request $request
     * @return View|array
     * 
     * @Rest\View(template="DBServiceBundle:Website:getWebsite.html.twig")
     */
    public function postOrganisationAction(Request $request) {
        $entity = new Website();
        $form = $this->createForm(new WebsiteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return array('entity' => $entity,);
        }
    }

}
