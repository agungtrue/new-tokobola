<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigInteger('user_id')->unique();
            $table->string('idcard_number', 16);
            $table->string('referrer', 255);
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_place', 255);
            $table->date('birth_date');
            $table->enum('religion', ['islam', 'protestan', 'katolik', 'hindu', 'buddha', 'konghucu']);
            $table->string('ethnic', 255);
            $table->string('domicile_phone_number', 14);
            $table->text('address');
            $table->string('province', 255);
            $table->string('city', 255);
            $table->string('sub_district', 255);
            $table->string('urban_village', 255);
            $table->string('postal_code', 20);
            $table->string('house_status', 255);
            $table->string('relationship_status', 255);
            $table->string('last_education', 255);
            $table->string('dependents', 255);
            $table->decimal('kpr_installment', 14);
            $table->string('idcard_image', 400);
            $table->string('pay_slip_image', 400);
            $table->string('profile_image', 400);
            $table->string('profession', 255);
            $table->string('work_position', 255);
            $table->string('work_start_year');
            $table->string('work_start_month');
            $table->decimal('monthly_income', 14);
            $table->decimal('monthly_expenses', 14);
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
        Schema::dropIfExists('members');
    }
}
