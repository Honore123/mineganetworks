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
        Schema::create('project_acceptances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_purchase_order_id')->references('id')->on('customer_purchase_orders')->onDelete(null);
            $table->string('acceptance_document');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_acceptances');
    }
};
