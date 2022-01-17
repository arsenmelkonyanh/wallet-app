<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('wallet_type_id')
                ->constrained('wallet_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('color')->nullable();
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign('wallets_user_id_foreign');
            $table->dropIndex('wallets_user_id_foreign');
            $table->dropForeign('wallets_wallet_type_id_foreign');
            $table->dropIndex('wallets_wallet_type_id_foreign');
        });

        Schema::dropIfExists('wallets');
    }
}
