<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Itemeerssfed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemeerssfesd', function (Blueprint $table) {
            $table->id();
            // $table->string('title');
            // $table->string('description' ) ->length(500);
            // $table->bigInteger('category_id') ->length(20)->unsigned()->nullable();
            // $table->foreign('category_id')->references('id')
            // ->on('categories')->onDelete('RESTRICT')->onUpdate('CASCADE');
            // $table->tinyInteger('in_orderes' ) ->default('1');
            // $table->Integer('order') ->length(2)->nullable();
            // $table->decimal('monthly_avg' ) ->length(8,2) -> default('0.00');
            // $table->enum('rate_star' , ['1' , '2', '3','4' ,'5'])->default('4');
            $table->addColumn(
                'Integer', 'hh',
                [
                    'length'   => 14 ,
                    'default'  => '1',
                    'autoIncrement' => false,
                    'unsigned' => false,
                    'null' => true,
                    'comment'  => 'Some comments'
                ]   
            );
            $table->bigInteger('menu_cat_id' ) ->nullable() ->change();
            $table->tinyInteger('is_available'  ) ->default(1);
            $table->decimal('sell_price' , 15,2 ) ;
            $table->decimal('monthly_avg' ,  8,2) -> default('0.00');
            $table->addColumn(
                'tinyInteger', 'field_name',
                [
                    'length'   => 1 ,
                    'default'  => '1',
                    'autoIncrement' => false,
                    'unsigned' => false,
                    'comment'  => 'Some comments'
                ]
            );
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
        //
    }
}
