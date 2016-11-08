<?php

use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ControleProjetos\Entities\ProjectTask::class, 10)->create();
    }
}
