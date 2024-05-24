<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 2,
            'password' => Hash::make('super_admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Super basic',
            'email' => 'superbasic@example.com',
            'role' => 2,
            'password' => Hash::make('super_basic'),
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );
    
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
