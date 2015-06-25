<?php

namespace DB\ServiceBundle\Controller;

use DB\ServiceBundle\Form\AccountHistoricType;
use DB\ServiceBundle\Entity\AccountHistoric;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class AccountHistoricController extends FOSRestController {

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get a AccountHistoric instance",
     *  output = "DB\ServiceBundle\Entity\AccountHistoric",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the AccountHistoric is not found"
     *   }
     * )
     * 
     * Get AccountHistoric instance
     * @param int $id Id of the AccountHistoric
     * @return array AccountHistoric
     * @throws NotFoundHttpException when AccountHistoric not exist
     * 
     * @Rest\View()
     */
    public function getAccountHistoric($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:AccountHistoric')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account Historic entity');
        }
        return array('entity' => $entity);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get all AccountHistoric instance",
     *  output = "DB\ServiceBundle\Entity\AccountHistoric",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned  when AccountHistoric table is empty"
     *   }
     * )
     * 
     * Get all AccountHistoric instance
     * @param int $id Id of the AccountHistoric
     * @return array AccountHistoric
     * @throws NotFoundHttpException when AccountHistoric table is empty
     * 
     * @return View()
     * 
     * @Rest\View()
     */
    public function getAccountHistoricsAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DBServiceBundle:AccountHistoric')->findAll();
        if (!$entities) {
            throw $this->createNotFoundException('No Organisations Account Historic found');
        }
        return array('entities' => $entities);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Delete a AccountHistoric",
     *  statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the AccountHistoric is not found"
     *   }
     * )
     * Delete a AccountHistoric
     * @param integer $id Id of the entity
     * @return View
     * @throws NotFoundHttpException when AccountHistoric not exist
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteAccountHistoricAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:AccountHistoric')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account Historic entity');
        }
        $em->remove($entity);
        $em->flush();
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Put a AccountHistoric instance",
     *  output = "DB\ServiceBundle\Entity\AccountHistoric",
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
     * @throws NotFoundHttpException when AccountHistoric not exist
     * 
     * @Rest\View(template="DBServiceBundle:AccountHistoric:getAccountHistoric.html.twig")
     */
    public function putAccountHistoricAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:AccountHistoric')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AccountHistoric entity');
        }
        $form = $this->createForm(new AccountHistoricType(), $entity);
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
     *  description="post a AccountHistoric instance",
     *  output = "DB\ServiceBundle\Entity\AccountHistoric",
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
     * @Rest\View(template="DBServiceBundle:AccountHistoric:getAccountHistoric.html.twig")
     */
    public function postAccountHistoricAction(Request $request) {
        $entity = new AccountHistoric();
        $form = $this->createForm(new AccountHistoricType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return array('entity' => $entity,);
        }
    }

}
