<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        \ControleProjetos\Entities\User::truncate();
//        \ControleProjetos\Entities\Client::truncate();
//        \ControleProjetos\Entities\Project::truncate();

        $this->call(UserTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(ProjectNoteTableSeeder::class);
        $this->call(OAuthClientTable::class);
        $this->call(ProjectTaskTableSeeder::class);

        Model::reguard();
    }
}
