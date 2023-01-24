<?php

namespace App\Controller;

use App\Repository\ExamRepository;
use App\Repository\ParamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewsController extends AbstractController
{
    /**
     * @Route("/", name="exam_index")
     */
    public function index(Request $request, ExamRepository $examRepository): Response
    {
        $errors = $request->query->get('errors');
        return $this->render('views/exam/index.html.twig', [
            'exams' => $examRepository->findAll(),
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/exam/{id}", name="exam_parameters")
     */
    public function exam(int $id, ParamRepository $paramRepository, ExamRepository $examRepository): Response
    {
        return $this->render('views/param/exam_params.html.twig', [
            'params' => $paramRepository->findBy(['exam' => $id]),
            'exam' => $examRepository->find($id)
        ]);
    }

    /**
     * @Route("/param", name="param_index")
     */
    public function param(ParamRepository $paramRepository, ExamRepository $examRepository): Response
    {
        return $this->render('views/param/index.html.twig', [
            'params' => $paramRepository->findAll(),
            'exams' => $examRepository->findAll()
        ]);
    }
}
