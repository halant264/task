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
            $table->bigInteger('category_id') ->length(20)->unsigned()->nullable();
            $table->foreign('category_id')->references('id')
            ->on('categories')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->tinyInteger('is_available') ->default('1');
            $table->tinyInteger('in_orderes') ->default('1');
            $table->Integer('order'  ) ->length(2)->nullable();
            $table->Integer('menu_order' ) ->length(3)->nullable();
            $table->bigInteger('menu_cat_id'  ) ->length(11)->nullable();
            // $table->bigInteger('category_id')->references('id')
            // ->on('categories')->onDelete('RESTRICT')->onUpdate('CASCADE')->nullable();
            $table->decimal('monthly_avg' ) ->length(8,2);
            $table->enum('rate_star' , ['1' , '2', '3','4' ,'5'])->default('4');
            $table->decimal('sell_price' ) ->length(15,2);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->Integer('parent_id' , 20 )->change()->nullable();


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
