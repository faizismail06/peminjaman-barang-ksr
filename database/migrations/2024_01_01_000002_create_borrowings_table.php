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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('borrower_name');
            $table->string('phone');
            $table->string('organization')->nullable();
            $table->date('borrow_date');
            $table->date('return_date');
            $table->integer('total_days'); // Jumlah hari peminjaman
            $table->decimal('total_cost', 12, 2)->default(0); // Total biaya
            $table->text('purpose');
            $table->string('spj')->nullable(); // File SPJ (PDF)
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
