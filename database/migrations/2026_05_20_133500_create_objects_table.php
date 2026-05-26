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
        Schema::create('objects', function (Blueprint $table) {
                $table->id();
        
                $table->foreignId('resource_id')
                    ->constrained('resources') 
                    ->cascadeOnDelete();       
                    
                $table->string('key');
                $table->float('size_mb');
                $table->string('mime_type', 100);
                $table->string('storage_path');
                $table->timestamp('created_at')->useCurrent();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objects');
    }
};
