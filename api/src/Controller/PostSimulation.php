<?php

namespace App\Controller;

use App\Entity\Simulation;
use App\Service\SimulationService;

class PostSimulation
{
    public function __construct(
        private SimulationService $service
    ) {}

    public function __invoke(Simulation $data)
    {
        $data->setTotalIncome($this->service->calculateTotalIncome($data));
        $data->setTax($this->service->calculateTotalIncomeTax($data));

        return $data;
    }
}
