<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = Config::first();
        if (is_null($config)) {
            Config::create([
                'seeded' => false
            ]);
        }
        if (!is_null($config) && !$config->seeded) {
            $config->seeded = true;
            $config->save();
        }
    }
}
