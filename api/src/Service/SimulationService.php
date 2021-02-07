<?php


namespace App\Service;


use App\Entity\Simulation;

class SimulationService
{
    public const INCOME_SLICE = [
        9964 => 0.14,
        27519 => 0.30,
        73779 => 0.41,
        156224 => 0.45,
    ];

    public function calculateTotalIncome(Simulation $simulation): int
    {
        return round($simulation->getNetIncome() / $this->getParts($simulation));
    }

    public function getParts(Simulation $simulation): float
    {
        return $simulation->getIsSingle() ? 1 : 2 + $simulation->getChildrenNumber() / 2;
    }

    public function calculateTotalIncomeTax(Simulation $simulation): int
    {
        return round($this->calculateTax(array_keys(self::INCOME_SLICE), $simulation->getTotalIncome()));
    }

    private function calculateTax(array $incomeSlices, int $totalIncome): float
    {
        $currentLice = array_pop($incomeSlices);
        if ($currentLice) {
            if ($totalIncome > $currentLice) {
                $currentTaxableIncome = $totalIncome - $currentLice;
                return self::INCOME_SLICE[$currentLice] * $currentTaxableIncome + $this->calculateTax($incomeSlices, $currentLice);
            } else {
                return $this->calculateTax($incomeSlices, $totalIncome);
            }
        }

        return 0;
    }
}
