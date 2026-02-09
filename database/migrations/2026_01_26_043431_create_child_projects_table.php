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
        Schema::create('child_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('project_url');
            $table->string('webhook_token');
            $table->foreignId('package_id')->constrained('packages','id')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_projects');
    }
};
