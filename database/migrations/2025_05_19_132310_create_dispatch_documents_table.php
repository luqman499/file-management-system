<?php

use App\Models\Dispatch;
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
        Schema::create('dispatch_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Dispatch::class)->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('file');
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatch_documents');
    }
};
