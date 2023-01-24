<?php

namespace App\Controller;

use App\Service\ExamService;
use App\Service\ParamService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionController extends AbstractController
{
    /**
     * @Route("/exam/create", name="exam_create", methods="POST")
     */
    public function createExam(Request $request, ExamService $examService): Response
    {
        $name = $request->request->get('name');
        $description = $request->request->get('description', '');

        if (empty($name)) {
            return $this->redirectToRoute('exam_index', ['errors' => ['Proszę uzupełnić pole nazwy badania.']]);
        }

        $examService->createExam($name, $description);

        return $this->redirectToRoute('exam_index');
    }

    /**
     * @Route("/param/create", name="param_create", methods="POST")
     */
    public function createParam(Request $request, ParamService $paramService, LoggerInterface $logger): Response
    {
        $name = $request->request->get('name');
        $value = (float) $request->request->get('value');
        $examId = (int) $request->request->get('exam');
        $errors = [];

        if (empty($name)) {
            $errors[] = 'Proszę uzupełnić pole nazwy parametru.';
        }
        if (empty($value)) {
            $errors[] = 'Proszę uzupełnić pole wartości parametru.';
        }
        if (empty($examId)) {
            $errors[] = 'Proszę wybrać prawidłowe badanie.';
        }

        if (!empty($errors)) {
            return $this->redirectToRoute('param_index', ['errors' => $errors]);
        }

        try {
            $logger->info(sprintf('Dodaję parametry badania o id:%d', $examId));
            $paramService->createParam($name, $value, $examId);
        } catch (\Exception $e) {
            $message = 'Niepowodzenie przy ustawieniu parametru badania.';
            $logger->error($message. ' ' .$e->getMessage());

            return $this->redirectToRoute('param_index', ['errors' => [$message]]);
        }

        $logger->info(sprintf('Pomyślnie dodano parametr badania.'));
        return $this->redirectToRoute('param_index', ['success' => true]);
    }
}
