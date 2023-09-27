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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'nameDocument', length:128);
            $table->string(column: 'authorControlDocument', length:128);
            $table->string(column: 'nameReceiverDocument', length:128);
            $table->string(column: 'funcntionReceiverDocument', length:128);
            $table->string(column: 'identityReceiverDocument', length:128);
            $table->string(column: 'rashDocument', length:128);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
