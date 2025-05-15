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
        // Eliminar columnas que no son necesarias
        Schema::table('users', function (Blueprint $table) {
            // Eliminar columnas de provincia y campos separados de facturación
            if (Schema::hasColumn('users', 'province')) {
                $table->dropColumn('province');
            }
            if (Schema::hasColumn('users', 'billing_city')) {
                $table->dropColumn('billing_city');
            }
            if (Schema::hasColumn('users', 'billing_postal_code')) {
                $table->dropColumn('billing_postal_code');
            }
            if (Schema::hasColumn('users', 'billing_province')) {
                $table->dropColumn('billing_province');
            }
            if (Schema::hasColumn('users', 'same_billing_address')) {
                $table->dropColumn('same_billing_address');
            }
        });
        
        // Asegurarse de que todos los campos requeridos estén presentes
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'billing_address')) {
                $table->string('billing_address')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('billing_address');
            }
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario revertir estos cambios
    }
};
