<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('username')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('email_user')->unique()->nullable();
            $table->string('role_user_siterpadu')->nullable();
            $table->string('nomor induk')->unique()->nullable();
            $table->string('photo')->nullable();
            $table->longText('password')->nullable();
            $table->boolean('use_oracle')->default(0);
            $table->boolean('is_local')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
