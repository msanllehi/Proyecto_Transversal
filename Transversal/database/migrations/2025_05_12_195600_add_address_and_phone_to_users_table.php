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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('birth_date');
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('province')->nullable()->after('postal_code');
            $table->string('billing_address')->nullable()->after('province');
            $table->string('billing_city')->nullable()->after('billing_address');
            $table->string('billing_postal_code')->nullable()->after('billing_city');
            $table->string('billing_province')->nullable()->after('billing_postal_code');
            $table->boolean('same_billing_address')->default(true)->after('billing_province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'city',
                'postal_code',
                'province',
                'billing_address',
                'billing_city',
                'billing_postal_code',
                'billing_province',
                'same_billing_address'
            ]);
        });
    }
};
