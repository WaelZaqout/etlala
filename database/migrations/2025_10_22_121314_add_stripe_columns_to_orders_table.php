<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('awaiting_payment')->after('total_price');
            }
            $table->string('stripe_session_id')->nullable()->after('status');
            $table->string('payment_intent')->nullable()->after('stripe_session_id');
            $table->index('stripe_session_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['stripe_session_id']);
            $table->dropColumn(['stripe_session_id', 'payment_intent']);
            // لا تحذف status إذا كان لديك مسبقًا
        });
    }
};
