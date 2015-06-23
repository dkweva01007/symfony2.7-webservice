<?php

namespace DB\ServiceBundle\Controller;

use DB\ServiceBundle\Form\OrganisationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class OrganisationController extends FOSRestController {

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get Organisation instance",
     *  output = "DB\ServiceBundle\Entity\Organisation",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the organisation is not found"
     *   }
     * )
     * 
     * Get Organisation instance
     * @param int $id Id of the Organisation
     * @return array Organisation
     * @throws NotFoundHttpException when Organisation not exist
     * 
     * @Rest\View()
     */
    public function getOrganisationAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Organisation')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find organisation entity');
        }
        return array('entity' => $entity);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get all Organisation instance",
     *  output = "DB\ServiceBundle\Entity\Organisation",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned  when Orgnisation table is empty"
     *   }
     * )
     * 
     * Get all Organisation instance
     * @param int $id Id of the Organisation
     * @return array Organisation
     * @throws NotFoundHttpException when Orgnisation table is empty
     * 
     * @return View
     */
    public function getOrganisationsAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DBServiceBundle:Organisation')->findAll();
        if (!$entities) {
            throw $this->createNotFoundException('No Organisations Entity found');
        }
        return array('entities' => $entities);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Delete a Organisation",
     *  statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the organisation is not found"
     *   }
     * )
     * Delete a Organisation
     * @var integer $id Id of the Organisation
     * @return View
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteOrganisationAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Organisation')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find organisation entity');
        }
        $em->remove($entity);
        $em->flush();
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get Organisation instance",
     *  output = "DB\ServiceBundle\Entity\Organisation",
     *  statusCodes = {
     *     200 = "Returned when the request success",
     *     204 = "Returned when the request fail"
     *   }
     * )
     * 
     * Put action
     * @var Request $request
     * @var integer $id Id of the entity
     * @return View|array
     * 
     * @Rest\View(DBServiceBundle::getOganisation.html.twig)
     */
    public function putOrganisationAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Organisation')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find organisation entity');
        }
        $form = $this->createForm(new OrganisationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return array('entity' => $entity,);
        }
    }

}
