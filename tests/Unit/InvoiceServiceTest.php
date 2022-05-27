<?php

namespace Tests\Unit;

use App\Services\Classes\InvoiceService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /**
     * A test that assert invoice service work properly.
     *
     * @return void
     */
    public function test_invoice_service_return_array_with_proper_data()
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
        $invoiceService = new InvoiceService();
        $result = $invoiceService->calculate($data);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('overall',$result);
        $this->assertArrayHasKey('components',$result);
        $this->assertArrayHasKey('energy',$result['components']);
        $this->assertArrayHasKey('time',$result['components']);
        $this->assertArrayHasKey('transaction',$result['components']);
    }
    /**
     * A test that assert invoice service work properly with improper data.
     *
     * @return void
     */
    public function test_invoice_service_return_array_with_improper_data()
    {
        $data = [];
        $invoiceService = new InvoiceService();
        $result = $invoiceService->calculate($data);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('overall',$result);
        $this->assertArrayHasKey('components',$result);
        $this->assertArrayHasKey('energy',$result['components']);
        $this->assertArrayHasKey('time',$result['components']);
        $this->assertArrayHasKey('transaction',$result['components']);
    }
}
