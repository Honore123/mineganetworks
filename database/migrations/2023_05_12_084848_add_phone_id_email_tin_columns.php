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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('email')->nullable()->after('vendor_name');
            $table->string('phone_number')->nullable()->after('email');
            $table->string('nat_id')->nullable()->after('phone_number');
            $table->integer('tin')->nullable()->after('nat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('phone_number');
            $table->dropColumn('nat_id');
            $table->dropColumn('tin');
        });
    }
};
