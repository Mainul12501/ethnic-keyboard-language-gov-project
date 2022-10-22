<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            // PermissionTableSeeder::class,
            // RoleTableSeeder::class,
            // UserTableSeeder::class,
            // DistrictTableSeeder::class,
            UpazilaTableSeeder::class,
            UnionTableSeeder::class,
        ]);


       /* DB::table('districts')->insert([
            ['name'=>'Bandarban', 'created_at'=>date("Y-m-d H:i:s")],
            ['name'=>'Natore', 'created_at'=>date("Y-m-d H:i:s")],
        ]);*/


        /*DB::table('users')->insert([
            [
                'name'          => 'Admin',
                'email'         => 'admin@gmail.com',
                'phone'         => '01744938010',
                'avatar'         => 'default.png',
                'password'      => bcrypt('1234567890'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
            [
                'name'          => 'Manager',
                'email'         => 'manager@gmail.com',
                'phone'         => '01744938010',
                'avatar'         => 'default.png',
                'password'      => bcrypt('1234567890'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
            [
                'name'          => 'Supervisor',
                'email'         => 'supervisor@gmail.com',
                'phone'         => '01744938010',
                'avatar'         => 'default.png',
                'password'      => bcrypt('1234567890'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
            [
                'name'          => 'Liguist',
                'email'         => 'linguist@gmail.com',
                'phone'         => '01744938010',
                'avatar'         => 'default.png',
                'password'      => bcrypt('1234567890'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
            [
                'name'          => 'Data Collector',
                'email'         => 'collector@gmail.com',
                'phone'         => '01744938010',
                'avatar'         => 'default.png',
                'password'      => bcrypt('1234567890'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
        ]);*/
    }
}
