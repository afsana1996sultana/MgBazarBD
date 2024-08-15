<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('name_bangla');
            $table->string('name_english');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('education');
            $table->date('dob', 20)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('national_id');
            $table->string('religious');
            $table->string('blood_g');
            $table->string('ocupation');
            $table->string('designation');
            $table->text('professional_add');
            $table->text('present_add');
            $table->text('permanent_add');
            $table->string('image');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=>Active, 0=>Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careers');
    }
}
