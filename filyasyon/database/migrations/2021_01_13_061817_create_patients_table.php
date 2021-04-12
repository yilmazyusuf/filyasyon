<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table)
        {
            $table->id();
            $table->string('name', 100);
            $table->bigInteger('tckn');
            $table->tinyInteger('age')->nullable();
            $table->bigInteger('gsm')->nullable();
            $table->date('detection_date')->nullable();
            $table->tinyInteger('bt_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('town_id')->nullable();
            $table->integer('neighborhood_id')->nullable();
            $table->integer('village_id')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('contact_place_id')->nullable();
            $table->boolean('is_health_personnel')->nullable();
            $table->tinyInteger('health_personnel_profession_id')->nullable();
            $table->tinyInteger('contact_origin_id')->nullable();
            $table->tinyInteger('relationship_to_main_case_id')->nullable();
            $table->integer('contacted_count')->nullable();
            $table->integer('contacted_pcr_positive_count')->nullable();
            $table->tinyInteger('patient_status_id')->nullable();
            $table->date('ex_date')->nullable();
            $table->date('healing_date')->nullable();
            $table->text('workplace')->nullable();
            $table->text('main_case_workplace')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tckn']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
