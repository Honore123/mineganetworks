<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_risks', function (Blueprint $table) {
            $table->string('assigned_to');
            $table->text('solution')->nullable();
            $table->timestamp('reported_at');
            $table->timestamp('resolved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_risks', function (Blueprint $table) {
            $table->dropColumn(['assigned_to', 'solution', 'reported_at', 'resolved_at']);
        });
    }
};
