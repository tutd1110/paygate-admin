<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_permission', function (Blueprint $table) {
            $table->id();
            $table->string('display_name',500)->nullable()->comment('name of group permission');
            $table->string('description',500)->nullable();
            $table->foreignId('tool_id')->constrained('tools')->comment('id of tool/feature');
            $table->string('actions',20)->default('0')->comment('1: view, 2: insert; 3: update, 4: delete eg: 1,2,3. NOT exceed actions in tools table');
            $table->tinyInteger('protection_level')->default(0)->comment('0: master, 1: mode, 2: superviser, 3: everyone. But NOT exceed protection_level in tools tables');
            $table->index('tool_id');
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
        Schema::dropIfExists('group_permission');
    }
}
