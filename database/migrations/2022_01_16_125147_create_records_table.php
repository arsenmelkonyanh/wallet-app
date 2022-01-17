<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount');
            $table->text('description')->nullable();
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
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign('records_user_id_foreign');
            $table->dropIndex('records_user_id_foreign');
            $table->dropForeign('records_wallet_id_foreign');
            $table->dropIndex('records_wallet_id_foreign');
        });

        Schema::dropIfExists('records');
    }
}
