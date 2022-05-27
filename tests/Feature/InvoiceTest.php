<?php

namespace Tests\Feature;

use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * A test for asserting the response of the API with proper data.
     *
     * @return void
     */
    public function test_response_has_properly_items_with_proper_input()
    {
        $data = [
            'rate' => [
                'energy' => '0.3',
                'time' => '2',
                'transaction' => '1',
            ],
            'cdr' =>[
                'meterStart'=> 1204307,
                'timestampStart'=> '2021-04-05T10:04:00Z',
                'meterStop'=> 1215230,
                'timestampStop'=> '2021-04-05T11:27:00Z'
            ]
        ];
        $response = $this->post('api/rate',$data);

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
    /**
     * A test for asserting the response of the API with improper data.
     *
     * @return void
     */
    public function test_response_has_properly_items_with_Improper_input()
    {
        $response = $this->post('api/rate');

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
