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
        Schema::table('survey_questions', function (Blueprint $table) {
            // Add is_required with default false as requested
            if (!Schema::hasColumn('survey_questions', 'is_required')) {
                $table->boolean('is_required')->default(false)->after('type');
            } else {
                $table->boolean('is_required')->default(false)->change();
            }

            // Add choices column (renaming from options if it exists, or just creating)
            if (Schema::hasColumn('survey_questions', 'options')) {
                $table->renameColumn('options', 'choices');
            } else if (!Schema::hasColumn('survey_questions', 'choices')) {
                $table->json('choices')->nullable()->after('is_required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->dropColumn(['is_required', 'choices']);
        });
    }
};
