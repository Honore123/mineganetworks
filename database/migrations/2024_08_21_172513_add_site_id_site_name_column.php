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
            $table->string('site_id')->after('risk_id');
            $table->string('site_name')->after('site_id');
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
            $table->dropColumn('site_id');
            $table->dropColumn('site_name');
        });
    }
};
