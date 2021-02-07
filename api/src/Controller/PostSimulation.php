<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\NoteRepository;
use App\Service\SimulationService;

class PostSimulation
{
    private NoteRepository $repo;

    public function __construct(
        SimulationService $repo
    ) {
        $this->repo = $repo;
    }

    public function __invoke(Student $data)
    {
        $data->setAverageNote($this->repo->getAverageNoteForStudent($data));

        return $data;
    }
}
