<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('championships', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('admin_id')->constrained('users');
            $table->foreignUuid('payment_id')->nullable()->constrained('payments');
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('edition', 50)->nullable();
            $table->text('logo_url')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('draft'); // 'draft', 'registration', 'group_stage', 'knockout', 'finished'
            // Format settings
            $table->integer('groups_count')->default(1);
            $table->integer('teams_per_group')->default(4);
            $table->integer('qualify_per_group')->default(2);
            // Scoring rules
            $table->integer('points_win')->default(3);
            $table->integer('points_draw')->default(1);
            $table->integer('points_loss')->default(0);
            $table->timestamps();
        });

        Schema::table('championships', function (Blueprint $table) {
            $table->index('admin_id');
            $table->index('payment_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('championships');
    }
};
