<?php

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

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
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Maiara' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Felipe' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Luis' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Leonardo' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Larissa' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Fernando' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Lorana' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Carlos' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Leandro' . rand(90000, 11),
                'image' => '',
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ]
        ]);
    }
}
