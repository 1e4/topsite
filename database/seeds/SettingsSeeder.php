<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('settings') as $setting => $options) {
            $s = new \App\Settings();
            $s->key = $setting;
            $s->value = $options['default'];
            $s->type = $options['type'];
            $s->save();
        }
    }
}
