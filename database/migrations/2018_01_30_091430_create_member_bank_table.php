<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_bank', function (Blueprint $table) {
            $table->bigInteger('user_id')->unique();
            $table->string('bank', 255)->nullable()->default(null);
            $table->string('bank_branch', 255)->nullable()->default(null);
            $table->string('bank_account_name', 255)->nullable()->default(null);
            $table->string('bank_account_number', 255)->nullable()->default(null);
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_bank');
    }
}
