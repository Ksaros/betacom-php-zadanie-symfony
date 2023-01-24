<?php

namespace App\Service;

use App\Entity\Exam;
use App\Entity\Param;
use App\Repository\ExamRepository;
use App\Repository\ParamRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParamService
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * Tworzy parametr badania.
     *
     * @param string $name
     * @param float $value
     * @param int $examId
     *
     * @throws Exception gdy wybrane badanie nie istnieje w bazie.
     *
     * @return Param
     */
    public function createParam(string $name, float $value, int $examId): Param
    {
        /** @var ExamRepository $examRepository */
        $examRepository = $this->em->getRepository(Exam::class);
        $exam = $examRepository->find($examId);

        if (!$exam instanceof Exam) {
            throw new \Exception('Brak badania w bazie.');
        }

        $param = new Param();
        $param
            ->setName($name)
            ->setValue($value)
            ->setExam($exam);

        /** @var ParamRepository $paramRepository */
        $paramRepository = $this->em->getRepository(Param::class);
        $paramRepository->add($param, true);

        return $param;
    }
}
