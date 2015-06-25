<?php

namespace DB\ServiceBundle\Controller;

use DB\ServiceBundle\Form\AccountType;
use DB\ServiceBundle\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class AccountController extends FOSRestController {

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get a Account instance",
     *  output = "DB\ServiceBundle\Entity\Account",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the Account is not found"
     *   }
     * )
     * 
     * Get Account instance
     * @param int $id Id of the Account
     * @return array Account
     * @throws NotFoundHttpException when Account not exist
     * 
     * @Rest\View()
     */
    public function getAccountAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Account')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity');
        }
        return array('entity' => $entity);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Get all Account instance",
     *  output = "DB\ServiceBundle\Entity\Account",
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned  when Account table is empty"
     *   }
     * )
     * 
     * Get all Account instance
     * @param int $id Id of the Account
     * @return array Account
     * @throws NotFoundHttpException when Account table is empty
     * 
     * @return View()
     * 
     * @Rest\View()
     */
    public function getAccountsAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('DBServiceBundle:Account')->findAll();
        if (!$entities) {
            throw $this->createNotFoundException('No Account Entity found');
        }
        return array('entities' => $entities);
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Delete a Account",
     *  statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the Account is not found"
     *   }
     * )
     * Delete a Account
     * @param integer $id Id of the entity
     * @return View
     * @throws NotFoundHttpException when Account not exist
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteAccountAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Account')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity');
        }
        $em->remove($entity);
        $em->flush();
    }

    /**
     * @ApiDoc(
     * resource=true,
     *  description="Put a Account instance",
     *  output = "DB\ServiceBundle\Entity\Account",
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
     * @throws NotFoundHttpException when Account not exist
     * 
     * @Rest\View(template="DBServiceBundle:Account:getAccount.html.twig")
     */
    public function putAccountAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DBServiceBundle:Account')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity');
        }
        $form = $this->createForm(new AccountType(), $entity);
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
     *  description="post a Account instance",
     *  output = "DB\ServiceBundle\Entity\Account",
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
     * @Rest\View(template="DBServiceBundle:Account:getAccount.html.twig")
     */
    public function postAccountAction(Request $request) {
        $entity = new Account();
        $form = $this->createForm(new AccountType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return array('entity' => $entity,);
        }
    }

}
