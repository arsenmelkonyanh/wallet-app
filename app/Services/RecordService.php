<?php

namespace App\Services;

use App\Models\Record;
use App\Models\Wallet;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class RecordService
{

    /**
     * Transfers amount from {from} wallet to {to} wallet.
     *
     * @param array $params
     * @param int $userId
     *
     * @return bool
     */
    public function transfer(array $params, int $userId): bool
    {
        $fromWallet = Wallet::find($params['from']);
        if (!$fromWallet->isOwner($userId)) {
            Log::error("Wallet doesn't belongs to user", ['userId' => $userId, 'walletId' => $fromWallet->id]);
            return false;
        }

        $params['type'] = Record::TYPE_DEBIT;

        // return false in case if unable to create record
        $success = $this->create($params, $userId, $fromWallet);
        if (!$success) {
            Log::error('Unable to create record', ['userId' => $userId, 'walletId' => $fromWallet->id, 'type' => $params['type'], 'amount' => $params['amount']]);
            return false;
        }

        $toWallet = Wallet::find($params['to']);
        if (!$toWallet->isOwner($userId)) {
            Log::error("Wallet doesn't belongs to user", ['userId' => $userId, 'walletId' => $toWallet->id]);
            return false;
        }

        $params['type'] = Record::TYPE_CREDIT;

        // return false in case if unable to create record
        $success = $this->create($params, $userId, $toWallet);
        if (!$success) {
            Log::error('Unable to create record', ['userId' => $userId, 'walletId' => $toWallet->id, 'type' => $params['type'], 'amount' => $params['amount']]);
            return false;
        }

        return true;
    }

    /**
     * Creates record by given params.
     *
     * @param array $params
     * @param int $userId
     * @param Wallet|null $wallet
     *
     * @return bool
     */
    public function create(array $params, int $userId, Wallet $wallet = null): bool
    {
        /** @var WalletService $walletService */
        $walletService = App::make(WalletService::class);

        // in case if called from controller
        if (!$wallet) {
            $wallet = Wallet::find($params['from']);
        }

        $record = new Record([
            'user_id' => $userId,
            'wallet_id' => $wallet->id,
            'type' => $params['type'],
            'amount' => $params['amount'],
            'description' => $params['description'] ?? null
        ]);

        // in case if record type is credit increases amount of wallet
        if ($params['type'] === Record::TYPE_CREDIT) {
            $success = $walletService->increaseAmount($wallet, (float)$params['amount']);

            if (!$success) {
                Log::error('Unable to increase amount', ['userId' => $userId, 'walletId' => $wallet->id, 'amount' => $params['amount']]);
                return false;
            }

            return $record->save();
        }

        // in case if record type is debit increases amount of wallet
        $success = $walletService->decreaseAmount($wallet, (float)$params['amount']);

        if (!$success) {
            Log::error('Unable to decrease amount', ['userId' => $userId, 'walletId' => $wallet->id, 'amount' => $params['amount']]);
            return false;
        }

        return $record->save();
    }
}
