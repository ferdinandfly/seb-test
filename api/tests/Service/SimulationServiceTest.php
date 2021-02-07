<?php

namespace App\Tests\Service;

use App\Entity\Simulation;
use App\Service\SimulationService;
use PHPUnit\Framework\TestCase;

class SimulationServiceTest extends TestCase
{

    public function testCalculateTotalIncome()
    {
        $simulation = new Simulation();
        $simulation->setIsSingle(true);
        $simulation->setNetIncome(1000);
        $simulation->setChildrenNumber(0);
        $service = new SimulationService();
        $this->assertEquals(1000, $service->calculateTotalIncome($simulation));
    }

    public function testCalculateTotalIncomeForCouple()
    {
        $simulation = new Simulation();
        $simulation->setIsSingle(false);
        $simulation->setNetIncome(1000);
        $simulation->setChildrenNumber(0);
        $service = new SimulationService();
        $this->assertEquals(500, $service->calculateTotalIncome($simulation));
    }

    public function testCalculateTotalIncomeForCoupleWithTwoChild()
    {
        $simulation = new Simulation();
        $simulation->setIsSingle(false);
        $simulation->setNetIncome(1000);
        $simulation->setChildrenNumber(2);
        $service = new SimulationService();
        $this->assertEquals(333, $service->calculateTotalIncome($simulation));
    }

    public function testGetTax()
    {
        $simulation = new Simulation();
        $simulation->setTotalIncome(9913);
        $service = new SimulationService();

        $this->assertEquals(0, $service->calculateTotalIncomeTax($simulation));

        $simulation = new Simulation();
        $simulation->setTotalIncome(27000);

        $this->assertEquals(2385, $service->calculateTotalIncomeTax($simulation));

        $simulation = new Simulation();
        $simulation->setTotalIncome(73000);

        $this->assertEquals(16102, $service->calculateTotalIncomeTax($simulation));

        $simulation = new Simulation();
        $simulation->setTotalIncome(150000);

        $this->assertEquals(47586, $service->calculateTotalIncomeTax($simulation));

        $simulation = new Simulation();
        $simulation->setTotalIncome(250000);

        $this->assertEquals(92337, $service->calculateTotalIncomeTax($simulation));
    }
}
