<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string("fullname");
            $table->string('student_number');
            $table->string('email')->unique();
            $table->string('year');
            $table->string('lvl_cleared')->default('0');
            $table->string('highscore')->default('0');
            $table->string('user_type')->default('player');
            $table->string('isPending')->default('pending');
            $table->timestamps();
        });

         // Insert default admin account
    DB::table('userprofiles')->insert([
        'firstname' => 'John Lemuel ',
        'middlename' => null,
        'lastname' => 'Encina',
        'fullname' => 'John Lemuel Encina',
        'student_number' => '00000000',
        'email' => 'johnlemuelencina30@gmail.com',
        'year' => 'N/A',
        'lvl_cleared' => 'N/A',
        'highscore' => 'N/A',
        'user_type' => 'admin',
        'isPending' => 'approved',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userprofiles');
    }
};
