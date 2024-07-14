<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name',500)->comment('tool name');
            $table->string('category',500)->comment('category of tool');
            $table->string('description',500)->nullable();
            $table->string('url',500)->comment('full url of tool/feature');
            $table->string('actions',20)->nullable()->comment('1: view, 2: insert; 3: update, 4: delete eg: 1,2,3');
            $table->tinyInteger('protection_level')->default(0)->comment('0: master, 1: mode, 2: superviser, 3: everyone');
            $table->index('category');
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
        Schema::dropIfExists('tools');
    }
}
