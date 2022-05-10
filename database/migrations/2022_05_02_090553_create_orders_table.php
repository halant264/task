<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('table_id');
                $table->foreign('table_id')->references('id')->on('tables')->onDelete('RESTRICT')->onUpdate('RESTRICT');
    
                // create table in database roles ,,, client 
               
                $table->datetime('orser_date');
                $table->decimal('total_price' , 12,2)->default('0.00');
                $table->tinyInteger('payment_state') ->default('0');
                $table->enum('payment_method' , ['card' , 'cash' , 'city_ledger' , 'voucher' , 'credit' ])->nullable();
                $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('RESTRICT')->onUpdate('RESTRICT');
                $table->enum('status' , ['pending' , 'preparing' , 'reserved' , 'done' , 'paid' , 'canceled'])->default('pending');
                $table->Integer('print_count');
                $table->Integer('customer');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('RESTRICT');
                $table->double('total_cost' , 10,2 )->nullable();
                $table->double('total_after_taxes' , 12,2 )->nullable();
                $table->double('discount_amount' , 12,2 )->nullable();
                $table->double('taxes' , 10,3 )->nullable();
                $table->double('consumption_taxs' , 10,3 )->nullable();
                $table->double('local_adminstration' , 10,3 )->nullable();
                $table->double('rebuild_tax' , 10,3 )->nullable();
                $table->string('notes'  )->nullable();
                $table->string('client_name' )->nullable();
                $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
