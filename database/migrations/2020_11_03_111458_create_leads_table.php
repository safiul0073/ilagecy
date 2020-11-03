<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('supplier_id');
            $table->foreignId('customer_id');
            $table->text('note')->nullable();
            $table->string('order_id')->nullable();
            $table->string('publisher_id')->nullable();
            $table->integer('status_admin')->default(3);
            $table->integer('status_caller')->default(3);
            $table->foreignId('caller_id')->default(0);
            $table->timestamp('update_admin')->nullable();
            $table->timestamp('update_caller')->nullable();
            $table->boolean('status')->default(true);
            $table->string('send_to_api')->nullable();
            $table->string('country_code')->nullable();
            $table->foreignId('duplicate_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['caller_id']);
        });

        Schema::dropIfExists('leads');
    }
}
