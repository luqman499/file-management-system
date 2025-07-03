<?php

use App\Models\User;
use App\Models\Dispatch;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dispatch_details', function (Blueprint $table) {
            $table->id();
             $table->foreignIdFor(Dispatch::class)->nullable()->onDelete('cascade');;
             $table->foreignIdFor(User::class)->nullable()->constrained();
                $table->string('remark')->nullable();
             $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatch_details');
    }
};
