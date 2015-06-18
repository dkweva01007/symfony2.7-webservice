<?php

// src/OC/PlatformBundle/Controller/DbController.php

namespace DB\porteBundle\Controller;

use DB\porteBundle\Entity\account;
use DB\porteBundle\Entity\Account_historic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DBaseController extends Controller {

    public function status_verif(&$account, &$historic) {
        //vérification de validité de la date du réplicat
        if (new \DateTime("now") < $historic->getDate()) {
            //verification du type de transaction
            if ($historic->getAmount() > 0) {
                $historic->setActionType("Crédit");
                //vérification de nouvelle date d'éxpiration du solde
                if ($account->getLimitDate() < $historic->getDate())
                    $account->setLimitDate($historic->getDate());
                //date de validité du réplicat devient date de la transaction
                $historic->setDate(new \Datetime());
            }elseif ($historic->getAmount() < 0)
                $historic->setActionType("Débit");
            else {
                $historic->setActionType("Extension de temps");
                //vérification de nouvelle date d'éxpiration du solde
                if ($account->getLimitDate() < $historic->getDate())
                    $account->setLimitDate($historic->getDate());
                //date de validité du réplicat devient date de la transaction
                $historic->setDate(new \Datetime());
                $historic->setAmount(0);
            }
            //verification si transaction débit/crédit possible
            if ($account->getAmount() + $historic->getAmount() >= 0) {
                $account->setAmount(
                        $account->getAmount() + $historic->getAmount()
                );
                $historic->setAmount(abs($historic->getAmount()));
                return true;
            } else
                return false;
        }
        return false;
    }

    public function viewAction(Request $request, $mail) {

        //creation de l'historique
        $history = new Account_historic();
        //on devrait sauvegarder dans une session l'ID du site
        //pour nos site partenaire
        $history->setWebsiteId(1);

        //permet de trouver l'user via son email
        $account = $this->getDoctrine()
                ->getRepository('DBporteBundle:account')
                ->findOneBymail($mail);
        //on recupére la clé du compte user pour l'historique
        $history->setUserId($account->getId());
        if (!$account) {
            throw $this->createNotFoundException(
                    'Cette User n\'existe pas'
            );
        } else {
            //recuperation des historique du compte
            $listhistoric = $this->getDoctrine()
                    ->getRepository('DBporteBundle:Account_historic')
                    ->findByUserId($history->getUserId());
            //creation du formulaire
            $formBuilder = $this->get('form.factory')->createBuilder('form', $history);
            $formBuilder
                    ->add('amount', 'money', array('currency' => 'EUR', 'precision' => 2))
                    //date de valité du réplicat
                    ->add('date', 'date')
                    ->add('Envoyer', 'submit');

            $form = $formBuilder->getForm();
            $form->handleRequest($request);
            //verification que l'envoie est correcté et effectué
            if ($form->isValid() && $form->isSubmitted() && $this->status_verif($account, $history)) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($history);
                $em->flush();
                $em->persist($account);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Ajout historique effectué.');
            }

            return $this->render('DBporteBundle:Consult:index.html.twig', array(
                        'user' => $account->getMail(),
                        'solde' => $account->getAmount(),
                        'limit_date' => $account->getLimitDate()->format('d/m/Y H:i:s'),
                        'form' => $form->createView(),
                        'listhistoric' => $listhistoric,
            ));
        }
    }

    public function addAction(Request $request) {
// Création de l'entité
        $solde = new Solde();
        $solde->setIdUser('Recherche développeur Symfony2.');
        $advert->setSolde('Alexandre');
        $advert->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");
// On peut ne pas définir ni la date ni la publication,
// car ces attributs sont définis automatiquement dans le constructeur
// On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

// Étape 1 : On « persiste » l'entité
        $em->persist($advert);

// Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();

// Reste de la méthode qu'on avait déjà écrit
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
        }

        return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }

}
