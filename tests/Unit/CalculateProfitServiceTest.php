<?php

namespace Tests\Unit;

use App\Services\CalculateProfitService;
use PHPUnit\Framework\TestCase;

class CalculateProfitServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_calculates_correctly()
    {
        $service = new CalculateProfitService(800, 10);
        $result = $service->calculateTotal();
    }
}
