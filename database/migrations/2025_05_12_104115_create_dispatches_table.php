<?php
use App\Models\Flag;
use App\Models\Folder;
use App\Models\Office;
use App\Models\User;
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
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Office::class)->nullable()->constrained();
             $table->foreignIdFor(Flag::class)->nullable()->constrained();
             $table->foreignIdFor(Folder::class)->nullable()->constrained();
             $table->string('title');
             $table->string('dispatch_number')->nullable();
             $table->string('file_number')->nullable();
             $table->string('description')->nullable();
             $table->date('date')->nullable(); // Changed from string to date
             $table->time('time')->nullable();
             $table->string('received_from')->nullable();
             $table->string('send_to')->nullable();
            $table->json('attachments')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatches');
    }
};
