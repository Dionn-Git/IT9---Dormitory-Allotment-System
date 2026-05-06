<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('concerns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->text('description');
            $table->enum('status', ['Pending', 'Acknowledged', 'Resolved'])->default('Pending');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('concerns');
    }
};