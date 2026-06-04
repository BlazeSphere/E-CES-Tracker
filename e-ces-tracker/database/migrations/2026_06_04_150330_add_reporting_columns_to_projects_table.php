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
            $table->string('category')->nullable()->after('description');
            $table->string('department')->nullable()->after('category');
            $table->integer('volunteers_count')->default(0)->after('budget');
            $table->integer('beneficiaries_count')->default(0)->after('volunteers_count');
            $table->decimal('completion_percentage', 5, 2)->default(0)->after('beneficiaries_count');
            $table->decimal('impact_score', 3, 2)->default(0)->after('completion_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['category', 'department', 'volunteers_count', 'beneficiaries_count', 'completion_percentage', 'impact_score']);
        });
    }
};
