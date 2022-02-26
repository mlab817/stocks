<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiHistoricalPriceControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_stores_historical_price_data()
    {
        $data = [];

        $response = $this->post(route('api.historical_prices.store'), [
            'company_id' => Company::inRandomOrder()->first()->id,
            'date' => today(),
        ]);

        $response->assertStatus(200);
    }
}
