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
        Schema::table('customer_purchase_orders', function (Blueprint $table) {
            $table->foreignId('project_id')->default(2)->after('po_number')->references('id')->on('projects')->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });
    }
};
