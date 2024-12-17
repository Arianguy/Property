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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->enum('paytype', ['CASH', 'CHEQUE'])->default('CHEQUE');
            $table->string('cheqno')->nullable();
            $table->string('cheqbank')->nullable();
            $table->decimal('cheqamt', 10, 2);
            $table->date('cheqdate');
            $table->enum('trans_type', ['RENT', 'SECURITY'])->default('RENT');
            $table->string('narration')->nullable();
            $table->date('depositdate')->nullable();
            $table->enum('cheqstatus', ['PENDING', 'DEPOSITED', 'BOUNCED'])->default('PENDING');
            $table->string('depositac')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
