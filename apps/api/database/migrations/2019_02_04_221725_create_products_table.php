<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->unique()->index();
            $table->string('sku', 40)->unique();
            $table->string('title');
            $table->string('url');
            $table->boolean('abstract')->default(false);
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image_url')->nullable();
            $table->integer('stock')->unsigned()->default(0);
            $table->timestamps();

            $table->primary('id');
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
