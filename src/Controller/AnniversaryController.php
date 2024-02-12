<?php

namespace App\Controller;

use App\Entity\Anniversary;
use App\Form\AnniversaryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnniversaryController extends AbstractController
{
    #[Route('/', name: 'app_anniversary')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $anniversary = $doctrine->getRepository(Anniversary::class)->findBy(['user' => $user], ['date' => 'ASC']);
        return $this->render('anniversary/index.html.twig', [
            'controller_name' => 'AnniversaryController',
            'anniversary' => $anniversary,
        ]);
    }

    #[Route('/ajout', name: 'app_anniversary_add')]
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $anniversary = new Anniversary();
        $form = $this->createForm(AnniversaryFormType::class, $anniversary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) { 
            $anniversary->setLastname($form['lastname']->getData());
            $anniversary->setFirstname($form['firstname']->getData());
            $anniversary->setDate($form['date']->getData());
            $anniversary->setUser($this->getUser());

            $manager->persist($anniversary);
            $manager->flush();
            return $this->redirectToRoute('app_anniversary');
        }

        return $this->render('anniversary/ajout.html.twig', [
            'controller_name' => 'AnniversaryController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edition/{id}', name: 'app_anniversary_edit')]
    public function edit(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $manager, $id): Response
    {
        $anniversary = $doctrine->getRepository(Anniversary::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AnniversaryFormType::class, $anniversary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $anniversary->setLastname($form['lastname']->getData());
            $anniversary->setFirstname($form['firstname']->getData());
            $anniversary->setDate($form['date']->getData());
            $anniversary->setUser($this->getUser());

            $manager->persist($anniversary);
            $manager->flush();
            return $this->redirectToRoute('app_anniversary');
        }

        return $this->render('anniversary/edit.html.twig', [
            'controller_name' => 'AnniversaryController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/suppression/{id}', name: 'app_anniversary_delete')]
    public function delete(ManagerRegistry $doctrine, EntityManagerInterface $manager, $id): Response
    {
        $anniversary = $doctrine->getRepository(Anniversary::class)->findOneBy(['id' => $id]);
        $manager->remove($anniversary);
        $manager->flush();

        $this->addFlash(
            'success',
            'Anniversaire supprimer !'
        );

        return $this->redirectToRoute('app_anniversary');
    }
}
