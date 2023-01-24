<?php

namespace App\Service;

use App\Entity\Exam;
use App\Repository\ExamRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ExamService
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function createExam(string $name, string $description): Exam
    {
        /** @var ExamRepository $examRepository */
        $examRepository = $this->em->getRepository(Exam::class);
        $exam = new Exam();
        $exam
            ->setName($name)
            ->setDescription($description)
            ->setCreateDt(new DateTime());

        $examRepository->add($exam, true);
        return $exam;
    }
}
