<?php

namespace DB\ServiceBundle\Controller;

use DB\ServiceBundle\Form\AccountType;
use DB\ServiceBundle\Entity\Account;
use DB\ServiceBundle\Entity\Website;
use DB\ServiceBundle\Entity\AccountHistoric;
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
     *     404 = "TRANSACTION: relica is obsolete.",
     *     404 = "EXTENDS TIME: no valid.",
     *     404 = "TRANSACTION: Not enough cash, stranger !!!",
     *     404 = "Returned when the request fail",
     *     404 = "Returned when the entity not exist"
     *   }
     * )
     * 
     * Put action
     * @param Request $request
     * @param integer $id Id of the entity
     * @return View|array
     * 
     */
    public function putAccountAction(Request $request, $id) {

        //recupération des donnée du compte
        $em = $this->getDoctrine()->getManager();
        $old = $em->getRepository('DBServiceBundle:Account')->find($id);
        //verification si compte trouvé
        if (!$old) {
            throw $this->createNotFoundException('no\'t found Account');
        }
        //création d'un compte temporaire avec même ID
        $new = new Account();
        //recuperation donnée
        $new->setMail($old->getMail());
        $new->setAmount($request->request->get('amount'));
        $new->setLimitDate(new \DateTime($request->request->get('limitDate')['date']));
        //creation d'un nouveau historique pour le compte
        $historic = new AccountHistoric();
        //on donne des information à l'historique
        $historic->setUser($old);
        $historic->setAmount($new->getAmount());
        //recupération entité Website
        $em = $this->getDoctrine()->getManager();
        $website = $em->getRepository('DBServiceBundle:Website')->find(
                $request->request->get('website_id')
                );
        $historic->setWebsite($website);
        //website temporaire
        /*$em = $this->getDoctrine()->getManager();
        $temp = $em->getRepository('DBServiceBundle:Website')->find($id);
        $historic->setWebsite($temp);*/
        //fin
        //si date de réplicat périmé
        if (new \DateTime("now") < $new->getLimitDate()) {
            //verification si CREDIT
            if ($new->getAmount() > 0) {
                $historic->setActionType("CREDIT");
                //vérification de nouvelle date d'éxpiration du solde
                if ($old->getLimitDate() <= $new->getLimitDate()) {
                    $old->setLimitDate($new->getLimitDate());
                }
                $historic->setDate(new \Datetime());
                //verification si DEBIT
            } elseif ($new->getAmount() < 0) {
                $historic->setActionType("DEBIT");
                $historic->setDate(new \Datetime());
                //verification si TIME EXTEND
            } else {
                $historic->setActionType("EXTENTION DE TEMPS");
                //vérification de nouvelle date d'éxpiration du solde
                if ($old->getLimitDate() <= $new->getLimitDate()) {
                    $old->setLimitDate($new->getLimitDate());
                    $historic->setDate(new \Datetime());
                    $historic->setAmount(0);
                } else {
                    throw $this->createNotFoundException('EXTENDS TIME: no valid.');
                }
            }
            //verification si transaction débit/crédit possible
            if ($old->getAmount() + $new->getAmount() >= 0) {
                $historic->setAmount(abs($new->getAmount()));
                $old->setAmount($new->getAmount() + $old->getAmount());
                $em = $this->getDoctrine()->getManager();
                $em->persist($old);
                $em->flush();
                $em->persist($historic);
                $em->flush();
                return array('entity' => $old);
            } else {
                throw $this->createNotFoundException('TRANSACTION: Not enough cash, stranger !!!');
            }
        } else {
            throw $this->createNotFoundException('TRANSACTION: relica is obsolete.');
        }
    }

    /**
     * 
     * He will confirm the transaction, and make a Account historic
     * @param Account $old the old information
     * @param Account $new the new information
     * @param AccountHistoric $historic the new Account's historic
     * @return View|array
     * @throws NotFoundHttpException when Not enough cash, stranger !!!
     * 
     * @Rest\View(template="DBServiceBundle:Account:getAccount.html.twig")
     */
    public function ConfirmTransaction(&$old, &$new, &$historic) {
        
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
        $entity->setAmount(0);
        $entity->setLimitDate(new \DateTime());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return array('entity' => $entity,);
        }
    }

}
