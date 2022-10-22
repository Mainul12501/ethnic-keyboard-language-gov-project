<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // 'Validation-Button',
            // 'Directed-Edit',
            // 'Approval-List',
            // 'Audio-Validation-Name',
            // 'Spontaneous-Edit'
            'Data Collection Show',
            'Data Collection Approve'
        ];

        foreach ($data as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
