<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique();
            $table->text('address')->nullable();
            $table->string('job')->nullable();
            $table->string('api_token')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('uuid')->unique()->nullable();
            $table->boolean('activated')->default(1);
            $table->string('avatar')->default('avatar.webp');
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
