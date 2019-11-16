<?php

class ProductTest extends TestCase
{
    /**
     * api/products [GET]
     */
    public function testShouldReturnAllProducts()
    {
        $this->get('api/products', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            [
                'name',
                'quantity',
                'price'
            ]
        ]);
    }

    /**
     * api/product/id [GET]
     */
    public function testShouldReturnProduct()
    {
        $this->get('api/product/1', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'name',
            'quantity',
            'price'
        ]);
    }
}
