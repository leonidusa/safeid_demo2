<?php

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Config;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api = config('env_custom.api');
        $oauth = config('env_custom.oauth');
        $data = array(
            'client_id' => config('env_custom.client_id'),
            'client_secret' => config('env_custom.client_secret'),
            'client_safe_id' => config('env_custom.client_safe_id'),
            'uri_oauth2' => $oauth.'oauth2',
            'uri_signin' => $api.'signin',
            'uri_transaction' => $api.'transaction',
            'uri_prompt' => $api.'prompt',
            'uri_checkclientaid' => $api.'checkclientaid',
            'uri_consumer' => $api.'consumer',
            'uri_application' => $api.'application',
        );

        DB::table('settings')->insert([
            'service' => 'safe',
            'data' => json_encode($data),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
