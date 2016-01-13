<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';

            $table->increments('id');
            $table->string('visit_year');
            $table->string('visit_month');
            $table->bigInteger('family_id');
            $table->bigInteger('member_id');
            $table->bigInteger('companion_id');
            $table->bigInteger('ward_id');
            $table->text('comment_text');
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
        Schema::drop('ward_comments');
    }
}
