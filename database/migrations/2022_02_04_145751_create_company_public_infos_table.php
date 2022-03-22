<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPublicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_public_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //$table->unsignedBigInteger('corporateNumber')->primary();///8.corporateNumber
            $table->unsignedBigInteger('corporateNumber');///8.corporateNumber
            $table->unsignedTinyInteger('process');//9.process
            $table->unsignedTinyInteger('correct');//10.correct
            $table->date('updateDate');//
            $table->date('changeDate');
            $table->string('name', 150);
//            $table->unsignedInteger('nameImageId')->nullable;
            $table->unsignedSmallInteger('kind');
            $table->string('prefectureName', 10);
            $table->string('cityName', 20);
            $table->text('streetNumber');
//            $table->unsignedInteger('addressImageId')->nullable;
            $table->unsignedTinyInteger('prefectureCode');
            $table->unsignedSmallInteger('cityCode');
            $table->unsignedInteger('postCode');
//            $table->text('addressOutside')->nullable;
//            $table->unsignedInteger('addressOutsideImageId')->nullable;
//            $table->date('closeDate')->nullable;
//            $table->unsignedTinyInteger('closeCause')->nullable;
//            $table->unsignedBigInteger('successorCorporateNumber')->nullable;
//            $table->text('changeCause')->nullable;
            $table->date('assignmentDate');
            $table->unsignedTinyInteger('latest');
//            $table->text('enName')->nullable;
//            $table->string('enPrefectureName', 9)->nullable;
//            $table->text('enCityName')->nullable;
//            $table->text('enAddressOutside')->nullable;
            $table->text('furigana');
            $table->unsignedTinyInteger('hihyoji');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_public_infos');
    }
}
