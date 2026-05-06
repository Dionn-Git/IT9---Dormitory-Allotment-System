<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->date('contract_start');
            $table->date('contract_end');
            $table->decimal('monthly_rate', 10, 2);
            $table->integer('payment_due_day')->default(1);
            $table->enum('status', ['Active', 'Ended', 'Terminated'])->default('Active');
            $table->text('termination_reason')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('contracts');
    }
};