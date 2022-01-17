<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('wallet_types')->insert([
            'name' => 'Credit cart'
        ]);
        DB::table('wallet_types')->insert([
            'name' => 'Cash'
        ]);
    }
}
