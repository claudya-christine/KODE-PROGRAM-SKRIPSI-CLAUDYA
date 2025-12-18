<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurustaff', function (Blueprint $table) {
            $table->string('staffID')->primary();
            $table->string('namalengkap');
            $table->date('tanggal_lahir');
            $table->string('posisi');
            $table->string('image')->nullable();
            $table->foreignId('unit_id')->constrained('unit_pendidikan')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurustaff');
    }
};
