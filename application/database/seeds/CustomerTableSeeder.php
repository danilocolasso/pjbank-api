<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Customer::create([
            'name'              => 'Danilo Colasso - Emp.',
            'email'             => 'danilo.colasso@gmail.com',
            'phone_number'      => '65999514855',
            'registered_number' => '58446858000164',
            'address'           => 'Rua Genebra',
            'address_2'         => 'Res. Bella Suíça',
            'number'            => 97,
            'city'              => 'Sinop',
            'state'             => 'MT',
            'zip_code'          => '78556589'
        ]);
    }
}
