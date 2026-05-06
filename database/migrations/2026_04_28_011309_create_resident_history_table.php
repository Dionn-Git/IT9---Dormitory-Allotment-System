<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('resident_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->date('contract_start');
            $table->date('contract_end');
            $table->decimal('monthly_rate', 10, 2);
            $table->enum('end_reason', [
                'contract_ended',
                'early_termination',
                'non_payment',
                'violation',
                'voluntary_exit'
            ]);
            $table->text('remarks')->nullable();
            $table->timestamp('moved_out_at');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('resident_history');
    }
};