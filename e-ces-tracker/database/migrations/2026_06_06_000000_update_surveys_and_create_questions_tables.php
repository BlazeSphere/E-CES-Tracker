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
        Schema::table('surveys', function (Blueprint $table) {
            if (!Schema::hasColumn('surveys', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('surveys', 'status')) {
                $table->enum('status', ['draft', 'active', 'closed'])->default('draft')->after('description');
            }
        });

        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->string('question_text');
            $table->enum('type', ['text', 'scale', 'multiple_choice'])->default('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
        
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn(['description', 'status']);
        });
    }
};
