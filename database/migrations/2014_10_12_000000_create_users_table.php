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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('unencrypted_password');
            $table->enum('role', ['admin', 'siswa', 'guru', 'caraka'])->default('siswa');
            $table->foreignId('kelas_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->tinyInteger('is_voted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
