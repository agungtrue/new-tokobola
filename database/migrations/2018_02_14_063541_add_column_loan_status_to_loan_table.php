<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLoanStatusToLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('status', [
                'submitted',
                'checking',
                'verified',
                'approved',
                'canceled',
                'rejected'
            ])->default('submitted')->after('reason');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
