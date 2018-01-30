<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_family', function (Blueprint $table) {
            $table->bigInteger('user_id')->unique();
            $table->string('family_name', 255);
            $table->string('family_phone_number', 14);
            $table->text('family_address');
            $table->string('family_province', 255);
            $table->string('family_city', 255);
            $table->string('family_sub_district', 255);
            $table->string('family_sub_urban_village', 255);
            $table->string('family_postal_code', 20);
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
        Schema::dropIfExists('member_family');
    }
}
