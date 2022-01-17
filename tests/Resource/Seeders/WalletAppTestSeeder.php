<?php

namespace Tests\Resource\Seeders;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WalletAppTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $testWalletTypeId = WalletType::create([
            'name' => 'Cash'
        ])->id;

        $testUserId = User::create([
            'name' => 'Test Name',
            'email' => 'test@test.test',
            'password' => Hash::make('gbL9zFB7xr6G')
        ])->id;

        Wallet::create([
            'user_id' => $testUserId,
            'wallet_type_id' => $testWalletTypeId,
            'name' => 'Test Wallet 1',
            'amount' => 500,
            'color' => Wallet::DEFAULT_COLOR
        ]);

        Wallet::create([
            'user_id' => $testUserId,
            'wallet_type_id' => $testWalletTypeId,
            'name' => 'Test Wallet 2',
            'amount' => 500,
            'color' => Wallet::DEFAULT_COLOR
        ]);
    }
}
