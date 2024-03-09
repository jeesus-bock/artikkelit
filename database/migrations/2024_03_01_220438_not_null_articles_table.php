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
        // 
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('draft')->change();
            // Allow multible users to edit
            $table->boolean('multi')->change();
            $table->unsignedBigInteger('updated_by')->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
