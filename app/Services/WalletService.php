<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class WalletService
{

    /**
     * Creates Wallet by given params.
     * Returns true in case if successfully created.
     * Otherwise returns false.
     *
     * @param array $params
     * @param int $userId
     *
     * @return bool
     */
    public function create(array $params, int $userId): bool
    {
        $wallet = new Wallet([
            'user_id' => $userId,
            'wallet_type_id' => $params['type'],
            'name' => $params['name'],
            'amount' => $params['amount'],
            'color' => $params['color'] ?? Wallet::DEFAULT_COLOR
        ]);

        $success = $wallet->save();

        if (!$success) {
            Log::error('Unable to create wallet', [
                'userId' => $userId,
                'walletTypeId' => $params['type'],
                'name' => $params['name'],
                'amount' => $params['amount'],
                'color' => $params['color']
            ]);
        }

        return $success;
    }

    /**
     * Deletes Wallet by given id.
     *
     * @param int $wallet
     * @param int $userId
     *
     * @return bool
     */
    public function delete(int $wallet, int $userId): bool
    {
        $wallet = Wallet::findOrFail($wallet);

        if (!$wallet->isOwner($userId)) {
            Log::error("Wallet doesn't belongs to user", ['userId' => $userId, 'walletId' => $wallet->id]);

            return false;
        }

        return (bool)$wallet->delete();
    }

    /**
     * Increases amount of given wallet.
     *
     * @param Wallet $wallet
     * @param float $amount
     *
     * @return bool
     */
    public function increaseAmount(Wallet $wallet, float $amount): bool
    {
        $currentAmount = $wallet->amount;

        $currentAmount += $amount;

        $wallet->amount = $currentAmount;

        return $wallet->save();
    }

    /**
     * Decreases amount of given wallet.
     *
     * @param Wallet $wallet
     * @param float $amount
     *
     * @return bool
     */
    public function decreaseAmount(Wallet $wallet, float $amount): bool
    {
        $currentAmount = $wallet->offsetGet('amount');

        $currentAmount -= $amount;

        $wallet->amount = $currentAmount;

        return $wallet->save();
    }


}
