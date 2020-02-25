<?php

use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    	{
        DB::table('task_types')->insert([
            'type_name' => 'Maintenance',
            'type_desc' => 'Maintain the network and the system',
        ]);
        DB::table('task_types')->insert([
            'type_name' => 'Debugging',
            'type_desc' => 'Find any errors or bugs that the system may have',
        ]);
        DB::table('task_types')->insert([
            'type_name' => 'Testing',
            'type_desc' => 'Test if the system if functional',
        ]);
        DB::table('task_types')->insert([
            'type_name' => 'Documents',
            'type_desc' => 'Document all the functionalities and the requirements of the system',
        ]);
        DB::table('task_types')->insert([
            'type_name' => 'Development',
            'type_desc' => 'Develop and design the system',
        ]);
    	}
}
