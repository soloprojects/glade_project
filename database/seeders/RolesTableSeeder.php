<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = ['superAdmin','admin','company','employee'];   //Designated Roles
        foreach($roles as $role){
            DB::table('roles')->insert([
                'role_desc' => $role,
            ]);

        }
    }
}
