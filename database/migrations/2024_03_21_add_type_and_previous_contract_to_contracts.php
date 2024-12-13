<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('type')->default('fresh');
            $table->foreignId('previous_contract_id')->nullable()->constrained('contracts')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropForeign(['previous_contract_id']);
            $table->dropColumn('previous_contract_id');
        });
    }
};
