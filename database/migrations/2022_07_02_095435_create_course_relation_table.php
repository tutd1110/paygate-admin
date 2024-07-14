<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_relation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->comment('Mã khóa học');
            $table->foreignId('course_relation_id')->nullable()->comment('Mã khóa học khác liên quan');
            $table->unsignedSmallInteger('sort')->default(9999)->comment('Mức độ ưu tiên. giá trị càng thấp ưu tiên càng cao');
            $table->foreignId('updated_by')->nullable()->comment('Người update');
            $table->timestamps();

            $table->index('course_id');
            $table->unique(['course_id','course_relation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_relation');
    }
}
