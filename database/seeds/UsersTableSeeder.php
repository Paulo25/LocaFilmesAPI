<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $User = new User();
        $User->insert([
            [
                'name'   => 'Paulo Vitor',
                'email' => 'paulo@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Maiara ' . str_random(10),
                'email' => 'maiara@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ],
            [
                'nome'   => 'Felipe ' . str_random(10),
                'email' => 'felipe@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => '2020-05-30 17:49:20',
                'updated_at' => '2020-05-30 17:49:20'
            ]
        ]);
    }
}
