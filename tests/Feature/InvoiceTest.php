<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * A test for asserting the response of the API.
     *
     * @return void
     */
    public function test_response_has_properly_items()
    {
        $response = $this->post('/rate');

        $response->assertStatus(200)
            ->assertJsonStructure([
               'overall',
               'components'=>[
                   'energy',
                   'time',
                   'transaction'
               ]
            ]);
    }
}
