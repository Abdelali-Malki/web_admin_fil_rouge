<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->string('photo', 200)->nullable();
            $table->integer('status')->default(1);
            $table->text('collections')->nullable();
            $table->text('collections_name')->nullable();
            $table->text('tags')->nullable();
            $table->integer('total_heart_count')->default(0);
            $table->integer('total_view_count')->default(0);
            $table->integer('total_download_count')->default(0);
            $table->dateTime('last_view_datetime')->nullable();
            $table->softDeletes('deleted_at', 0);
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
