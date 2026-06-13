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
            Schema::create('members', function (Blueprint $table) {
                $table->id();
                $table->string('member_code')->unique()->index(); // e.g., GYM001 - Indexed for fast search
                $table->string('name')->index();
                $table->string('phone')->unique()->index();
                $table->string('email')->nullable()->unique();
                $table->date('date_of_birth')->nullable();
                $table->string('gender')->nullable();
                $table->text('address')->nullable();
                $table->string('profile_image_path')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
                $table->softDeletes(); // Allows "Trash" without permanent deletion
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
