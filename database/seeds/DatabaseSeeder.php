<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name'   => 'Test Name'
        	,'email' => 'test@test.com'
        	,'password'          => \Hash::make('secret')
        	,'status'            => 1
        	,'remember_token'    => null
        	,'created_at'        => Carbon::now()
        	,'updated_at'        => null
        ]);
    }
}
