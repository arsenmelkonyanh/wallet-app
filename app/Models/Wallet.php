<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public const DEFAULT_COLOR = '#000000';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wallet_type_id',
        'name',
        'amount',
        'color'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet_type()
    {
        return $this->belongsTo(WalletType::class);
    }

    /**
     * Returns true in case if user with given id is owner of wallet.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isOwner(int $userId): bool
    {
        return $this->user_id === $userId;
    }
}
