<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_company', function (Blueprint $table) {
            $table->bigInteger('user_id')->unique();
            $table->string('company_name', 255);
            $table->string('company_phone_number', 14);
            $table->text('company_address');
            $table->string('company_province', 255);
            $table->string('company_city', 255);
            $table->string('company_sub_district', 255);
            $table->string('company_urban_village', 255);
            $table->string('company_postal_code', 20);
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
        Schema::dropIfExists('member_company');
    }
}
