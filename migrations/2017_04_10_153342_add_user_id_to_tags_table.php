<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('taggable.tags_table_name'), function (Blueprint $table) {
            $table->integer('user_id')->nullable();
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
        Schema::table(config('taggable.tags_table_name'), function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('created_at', 'updated_at');
        });
    }
}
