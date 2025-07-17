<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('host')->comment('Mail server');
            $table->string('port', 10)->default('465')->comment('Mail server port');
            $table->string('encryption', 10)->default('ssl')->comment('Mail server port');
            $table->string('username')->comment('Your Email');
            $table->string('password')->comment('Your Password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
