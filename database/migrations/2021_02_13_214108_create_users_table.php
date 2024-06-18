<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->string('username', 110)->unique();
            $table->string('password', 100);
            $table->unsignedBigInteger('business_id')->nullable()->index();
            $table->unsignedBigInteger('file_id')->nullable()->index();
            $table->boolean('is_admin')->default(0);
            $table->string('email', 200);
            $table->string('phone', 200);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('users');
    }
}
