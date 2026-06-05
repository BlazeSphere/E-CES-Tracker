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
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'start_date')) {
                $table->date('start_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('projects', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
