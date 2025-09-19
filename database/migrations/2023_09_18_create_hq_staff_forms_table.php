<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hq_staff_forms', function (Blueprint $table) {
            $table->id();
            // Section 1: Personal Information
            $table->string('fullName');
            $table->string('fathersName')->nullable();
            $table->string('mothersName')->nullable();
            $table->date('dateOfBirth');
            $table->string('placeOfBirth')->nullable();
            $table->string('idPassportNumber')->nullable();

            // Section 2: Contact & Location
            $table->text('fullAddress')->nullable();
            $table->string('phoneNumber');
            $table->string('whatsappNumber')->nullable();
            $table->string('region')->nullable();
            $table->string('placeOfResidence')->nullable();
            $table->string('departmentOfOrigin')->nullable();
            $table->string('village')->nullable();
            $table->string('ethnicity')->nullable();
            $table->integer('numberOfSiblings')->nullable();
            $table->string('nextOfKinName')->nullable();
            $table->string('nextOfKinCity')->nullable();
            $table->string('nextOfKinContact')->nullable();
            $table->string('familyHeadName')->nullable();
            $table->string('familyHeadCity')->nullable();
            $table->string('familyHeadContact')->nullable();

            // Section 3: Spiritual Life
            $table->date('conversionDate')->nullable();
            $table->string('baptismByImmersion')->nullable();
            $table->string('baptismInHolySpirit')->nullable();
            $table->string('homeChurch')->nullable();
            $table->string('center')->nullable();
            $table->string('discipleMakerName')->nullable();
            $table->string('discipleMakerContact')->nullable();
            $table->string('spiritualParentageName')->nullable();
            $table->string('spiritualParentageContact')->nullable();
            $table->text('spiritualParentageRelationship')->nullable();
            $table->text('testimony')->nullable();

            // Section 4: Family Life
            $table->string('maritalStatus');
            $table->string('spouseName')->nullable();
            $table->string('spouseContact')->nullable();
            $table->integer('numberOfLegitimateChildren')->nullable();
            $table->text('legitimateChildrenDetails')->nullable();
            $table->integer('numberOfDependents')->nullable();
            $table->text('dependentsDetails')->nullable();
            $table->text('siblingsDetails')->nullable();

            // Section 5: Professional Life
            $table->string('educationFinancer')->nullable();
            $table->string('educationLevel')->nullable();
            $table->string('degreeObtained')->nullable();
            $table->text('activityBeforeHQ')->nullable();
            $table->date('hqEntryDate')->nullable();
            $table->string('hqDepartment')->nullable();
            $table->string('originCountryCity')->nullable();
            $table->text('departmentResponsibility')->nullable();

            // Section 6: Commissioning
            $table->text('whoIntroducedToHQ')->nullable();
            $table->string('callOfGod')->nullable();
            $table->text('whatCallConsistsOf')->nullable();
            $table->string('familyAwareOfCall')->nullable();
            $table->string('emergencyContactDeath')->nullable();
            $table->string('burialLocation')->nullable();

            // Section 7: Possessions & Health
            $table->text('yourPossessions')->nullable();
            $table->text('sourcesOfIncome')->nullable();
            $table->text('healthProblems')->nullable();
            $table->string('underTreatment')->nullable();
            $table->text('operationsDetails')->nullable();

            // Section 8: Judicial History
            $table->string('problemsWithAnyone')->nullable();
            $table->text('reasonForProblems')->nullable();
            $table->string('beenToPrison')->nullable();
            $table->text('reasonForPrison')->nullable();

            // Section 9: Documents
            $table->string('bulletin3_path')->nullable();
            $table->string('medical_certificate_path')->nullable();
            $table->string('diplomas_path')->nullable();
            $table->string('birth_marriage_certificates_path')->nullable();
            $table->string('cni_path')->nullable();
            $table->string('family_commitment_path')->nullable();
            $table->string('family_burial_agreement_path')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hq_staff_forms');
    }
};