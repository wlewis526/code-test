<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/*
		- ID
- Name
- Description
- Price
- Image

		*/
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->string("name");
			$table->string("description");
			$table->decimal("price", 11, 2);
			$table->string("image")->nullable();
			$table->unsignedInteger("created_by")->nullable();
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
        Schema::dropIfExists('products');
    }
}
