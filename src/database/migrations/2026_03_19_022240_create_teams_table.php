<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('championship_id')->constrained('championships')->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('short_name', 10)->nullable();
            $table->text('logo_url')->nullable();
            $table->string('primary_color', 7)->nullable();
            $table->string('secondary_color', 7)->nullable();
            $table->string('coach_name', 100)->nullable();
            $table->timestamps();

            $table->unique(['championship_id', 'name']);
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->index('championship_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
