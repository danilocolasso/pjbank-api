<?php

class OrderTest extends TestCase
{
    /**
     * api/order [POST]
     */
    public function testShouldCreateOrder()
    {
        $this->post('api/products', [
            'products' => [
                ['id' => 1, 'quantity' => 2],
                ['id' => 5, 'quantity' => 1],
                ['id' => 9, 'quantity' => 1]
            ]
        ]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'order_id',
            'quantity',
            'price',
            'date',
            'link_boleto',
            'cod_barras'
        ]);
    }
}
