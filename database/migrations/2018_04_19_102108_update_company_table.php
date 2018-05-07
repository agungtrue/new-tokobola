<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->string('name')->nullable()->default(null)->after('key');
            $table->string('phone_number', 14)->nullable()->default(null)->after('name');
            $table->text('address')->nullable()->default(null)->after('phone_number');
            $table->string('province', 255)->nullable()->default(null)->after('address');
            $table->string('city', 255)->nullable()->default(null)->after('province');
            $table->timestamp('created_at')->nullable()->after('updated_at');
            $table->timestamp('deleted_at')->nullable()->default(NULL)->after('created_at');
            $table->dropColumn('user_id');
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
