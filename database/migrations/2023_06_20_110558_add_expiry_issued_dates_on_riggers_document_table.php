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
        Schema::table('rigger_documents', function (Blueprint $table) {
            $table->date('issued_date')->nullable()->after('document');
            $table->date('expiry_date')->nullable()->after('document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rigger_documents', function (Blueprint $table) {
            $table->dropColumn('issued_date');
            $table->dropColumn('expiry_date');
        });
    }
};
