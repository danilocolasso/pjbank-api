<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OrderController extends Order
{
    private $apiKey;
    private $apiUrl;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->apiKey = env('PJBANK_API_KEY');
        $this->apiUrl = env('PJBANK_API_URL');
    }

    /**
     * Create a new Order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        //TODO change id
        $customer = Customer::find(1);
        $products = $request->get('products');

        $order = $customer->orders()->create([
            'quantity'  => count($products),
            'price'     => 0
        ]);

        foreach($products as $product) {
            $order->products()->attach(
                $product['id'],
                ['quantity' => $product['quantity']]
            );
        }

        $order->price = $order->products()->sum('price');
        $order->save();

        return response()->json($order);
        return $this->getBoleto($order);
    }

    /**
     * Send a PJBANK request and return link to the bill and bar code
     *
     * @param $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getBoleto($order)
    {
        $customer = $order->customer;

        $url = implode('/', [
            $this->apiUrl,
            'recebimentos',
            $this->apiKey,
            'transacoes'
        ]);

        $date = new \DateTime();
        $date->modify('+1 month');

        $params = [
            'form_params' => [
                'vencimento'        => $date->format('m/d/Y'),
                'valor'             => $order->price,
                'juros'             => 0,
                'juros_fixo'        => 0,
                'multa'             => 0,
                'multa_fixo'        => 0,
                'desconto'          => 0,
                'nome_cliente'      => $customer->name,
                'email_cliente'     => $customer->email,
                'telefone_cliente'  => $customer->phone_number,
                'cnpj_cliente'      => $customer->registered_number,
                'endereco_cliente'  => $customer->address,
                'numero_cliente'    => $customer->number,
                'bairro_cliente'    => $customer->address_2,
                'cidade_cliente'    => $customer->city,
                'estado_cliente'    => $customer->state,
                'cep_cliente'       => $customer->zip_code,
                'pediro_numero'     => $order->id
            ]
        ];

        $client = new Client();
        $response = $client->request('POST', $url, $params);

        return response()->json([
            'order_id'      => $order->id,
            'quantity'      => $order->quantity,
            'price'         => $order->price,
            'date'          => $order->created_at,
            'link_boleto'   => $response['linkBoleto'],
            'cod_barras'    => $response['linhaDigitavel']
        ]);
    }
}
