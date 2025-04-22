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
        Schema::create('status_berlangganans', function (Blueprint $table) {
            $table->bigIncrements('status_id'); // Ganti id dengan status_id sebagai primary key
            $table->string('nama_status');  // Tambahkan kolom untuk nama status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_berlangganans');
    }
};
