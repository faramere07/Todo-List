<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\UserType;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        UserType::create([
            'type_name' => 'Admin',
        ]);

        UserType::create([
            'type_name' => 'Task Master',
        ]);

        UserType::create([
            'type_name' => 'User',
        ]);
    }
}
