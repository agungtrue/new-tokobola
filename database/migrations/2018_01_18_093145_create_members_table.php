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
            $table->string('referrer', 255)->nullable()->default(null);
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_place', 255)->nullable()->default(null);
            $table->date('birth_date')->nullable()->default(null);
            $table->enum('religion', ['islam', 'protestan', 'katolik', 'hindu', 'buddha', 'konghucu'])->nullable()->default(null);
            $table->string('ethnic', 255)->nullable()->default(null);
            $table->string('domicile_phone_number', 14)->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('province', 255)->nullable()->default(null);
            $table->string('city', 255)->nullable()->default(null);
            $table->string('sub_district', 255)->nullable()->default(null);
            $table->string('urban_village', 255)->nullable()->default(null);
            $table->string('postal_code', 20)->nullable()->default(null);
            $table->string('house_status', 255)->nullable()->default(null);
            $table->string('relationship_status', 255)->nullable()->default(null);
            $table->string('last_education', 255)->nullable()->default(null);
            $table->string('dependents', 255)->nullable()->default(0);
            $table->decimal('kpr_installment', 14)->nullable()->default(0);
            $table->string('idcard_image', 400)->nullable()->default(null);
            $table->string('pay_slip_image', 400)->nullable()->default(null);
            $table->string('profile_image', 400)->nullable()->default(null);
            $table->string('profession', 255)->nullable()->default(null);
            $table->string('work_position', 255)->nullable()->default(null);
            $table->string('work_start_year')->nullable()->default(null);
            $table->string('work_start_month')->nullable()->default(null);
            $table->decimal('monthly_income', 14)->nullable()->default(null);
            $table->decimal('monthly_expenses', 14)->nullable()->default(null);
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
