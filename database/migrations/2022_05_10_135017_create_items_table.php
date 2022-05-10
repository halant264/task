<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description' ) ->length(500);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('RESTRICT')->onUpdate('CASCADE');

            $table->tinyInteger('is_available'  ) ->default(1);
            $table->tinyInteger('in_orderes' ) ->default('1');
            $table->Integer('order')->nullable();
            $table->Integer('menu_order' )->nullable();
            $table->enum('rate_star' , ['1' , '2', '3','4' ,'5'])->default('4');
            $table->bigInteger('menu_cat_id' ) ->nullable();
            $table->decimal('sell_price' , 15,2 ) ;
            $table->decimal('monthly_avg' ,  8,2)->default('0.00');
            $table->timestamps();
            $table->softDeletes();
            $table->Integer('parent_id')->lenght('20') ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
