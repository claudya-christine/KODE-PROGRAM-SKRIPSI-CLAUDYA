




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
    Schema::create('kegiatan', function (Blueprint $table) {
        $table->id();
        $table->string('namaKegiatan');
        $table->text('deskripsi');
        $table->string('image');
        $table->foreignId('unit_id')->constrained('unit_pendidikan'); 
        $table->boolean('is_active')->default(true);  
        $table->softDeletes(); 
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
