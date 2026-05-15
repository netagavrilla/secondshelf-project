<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('external_id')->nullable();
        $table->string('xendit_invoice_id')->nullable();
        $table->text('xendit_invoice_url')->nullable();
        $table->string('payment_status')->default('PENDING');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn([
            'external_id',
            'xendit_invoice_id',
            'xendit_invoice_url',
            'payment_status',
        ]);
    });
}
};
