<?php

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cliente = new Cliente();
        $cliente->insert([
            [
                'nome'   => 'Paulo Vitor',
                'image' => '',
                'cpf_cnpj' => '07596589689'
            ],
            [
                'nome'   => 'Maiara',
                'image' => '',
                'cpf_cnpj' => '05224585487'
            ],
            [
                'nome'   => 'Felipe',
                'image' => '',
                'cpf_cnpj' => '32165478998'
            ]
        ]);
    }
}
