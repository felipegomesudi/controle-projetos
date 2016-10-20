<?php

use Illuminate\Database\Seeder;

class OAuthClientTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            [
                'id' => 'appid1',
                'secret' => 'secret',
                'name' => 'AngularApp',
                'created_at' =>  '2016-10-20 00:00:00:00',
                'updated_at' =>  '2016-10-20 00:00:00:00'
            ]
        ]);
    }
}
