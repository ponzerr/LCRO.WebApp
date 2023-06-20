<!-- show.index.blade.php -->


@extends('layouts.app')

@section('content')
@auth
<div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">APPLICATION FOR MARRIAGE LICENSE</h2>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Details</p>
            <p>Please fill out all the fields.</p>
          </div>

            <div class="lg:col-span-2">
              <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                  <div class="md:col-span-3">
                      <label for="mcert_province">Province</label>
                      <h1 name="mcert_province" id="mcert_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_province }}</h1> 
                    </div>

                    <div class="md:col-span-2">
                      <label for="mcert_registry_no">Registry No.</label>
                      <h1 name="mcert_registry_no" id="mcert_registry_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_registry_no }}</h1> 
                    </div>

                    <div class="md:col-span-5">
                      <label for="mcert_municipality">City/Municipality</label>
                      <h1 name="mcert_municipality" id="mcert_municipality" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_municipality }}</h>
                    </div>

                    <div class="md:col-span-3">
                      <label for="mcert_received_by">Received by</label>
                      <h1 name="mcert_received_by" id="mcert_received_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_received_by }}</h1> 
                    </div>

                    <div class="md:col-span-2">
                      <label for="mcert_marriage_license_no">Marriage License No.</label>
                      <h1 name="mcert_marriage_license_no" id="mcer_marriage_license_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_marriage_license_no }}</h1> 
                    </div>

                    <div class="md:col-span-3">
                      <label for="mcert_date_of_receipt">Date of Receipt</label>
                      <h1 name="mcert_date_of_receipt" id="mcert_date_of_receipt" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_date_of_receipt }}</h1>  
                    </div>

                    <div class="md:col-span-2">
                      <label for="mcert_date_of_issuance">Date of Issuance of Marriage License</label>
                      <h1 name="mcert_date_of_issuance" id="mcert_date_of_issuance" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_date_of_issuance }}</h1>
                    </div>
                  
                </div>
              </div>
            </div>
          </div>
<!-- Groom Data Form -->
          <div class="min-h-screen bg-gray-100 flex items-center justify-center">
  <div class="container max-w-screen-lg mx-auto">
    
      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Groom Details</p>
            <p>Please fill out all the fields.</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
            <!-- Name of Applicant -->
            <label class="md:col-span-6">1. Name of Applicant</label>
            <div class="md:col-span-6">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_last_name }}, {{ $mcert->mcert_g_first_name }} {{ $mcert->mcert_g_middle_name }}</h1>      
              </div>
            
            <!-- Date of Birth/Age -->
            <label class="md:col-span-6">2. Date of Birth/Age</label>
            <div class="md:col-span-4">
              <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_date_of_birth }}</h1>
              </div>
            <div class="md:col-span-2">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_age }}</h1>
              </div>

              
             <!-- Place of Birth -->
             <label class="md:col-span-6">3. Place of Birth</label>
            <div class="md:col-span-2">
            <label for="mcert_g_place_of_birth_city">(Municipality/City)</label>
                <h1 name="mcert_g_place_of_birth_city" id="mcert_g_place_of_birth_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_place_of_birth_city }}</h1>
              </div>
            <div class="md:col-span-2">
            <label for="mcert_g_place_of_birth_province">(Province)</label>
                <h1 name="mcert_g_place_of_birth_province" id="mcert_g_place_of_birth_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_place_of_birth_province }}</h1>
              </div>
              <div class="md:col-span-2">
              <label for="mcert_g_place_of_birth_country">(Country)</label>
                <h1 name="mcert_g_place_of_birth_country" id="mcert_g_place_of_birth_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{$mcert->mcert_g_place_of_birth_country}}</h1>
              </div>    
            

            <!-- Sex/Citizenship -->
            <label class="md:col-span-6">4. Sex/Citizenship</label>
            <div class="md:col-span-2">
                <label for="mcert_g_sex">(Male/Female)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_g_sex" id="mcert_g_sex" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_sex }}</h1>    
                    </div>
              </div>

              <div class="md:col-span-4">
                <label for="mcert_g_citizenship">(Citizenship)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_g_citizenship" id="mcert_g_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_citizenship }}</h1>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_g_residence">5. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_g_residence" id="mcert_g_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_residence }}</h1>
              </div>

              <!-- Religion/Religious Sect -->
              <div class="md:col-span-6">
                <label for="mcert_g_religion">6. Religion/Religious Sect</label>
                <h1 name="mcert_g_religion" id="mcert_g_religion" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_religion }}</h1>
              </div>

              <!-- Civil Status -->
              <div class="md:col-span-6">
                <label for="mcert_g_civil_status">7. Civil Status</label>
                <h1 name="mcert_g_civil_status" id="mcert_g_civil_status" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_civil_status }}</H1>
              </div>

              <!-- if Previoulsy Married -->
              <div class="md:col-span-6">
                <label for="mcert_g_marriage_dissolved">8. IF PREVIOUSLY MARRIED: How was it dissolved?</label>
                <h1 name="mcert_g_marriage_dissolved" id="mcert_g_marriage_dissolved" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_marriage_dissolved }}</H1>
              </div>
              
              <!-- Place Where Dissolved -->
              <label class="md:col-span-6">9. Place where dissolved</label>
            <div class="md:col-span-2">
            <label for="mcert_g_marriage_dissolved_place_city">(City/Municipality)</label>
                <h1 name="mcert_g_marriage_dissolved_place_city" id="mcert_g_marriage_dissolved_place_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_marriage_dissolved_place_city }}</h1>
              </div>
            <div class="md:col-span-2">
            <label for="mcert_g_marriage_dissolved_place_province">(Province)</label>
                <h1 name="mcert_g_marriage_dissolved_place_province" id="mcert_g_marriage_dissolved_place_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_marriage_dissolved_place_province }}</h1>
              </div>
              <div class="md:col-span-2">
              <label for="mcert_g_marriage_dissolved_place_country">(Country)</label>
                <h1 name="mcert_g_marriage_dissolved_place_country" id="mcert_g_marriage_dissolved_place_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_marriage_dissolved_place_country }}</h1>
              </div>    

              <!-- Date when dissoved -->
              <div class="md:col-span-6">
              <label for="mcert_g_marriage_dissolved_date">10. Date when dissolved</label>
                <h1 name="mcert_g_marriage_dissolved_date" id="mcert_g_marriage_dissolved_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_marriage_dissolved_date }}</h1>
              </div>

              <!-- Degree of relationship of contracting of contracting parties -->
              <div class="md:col-span-6">
                <label for="mcert_g_marriage_dissolved_relationship">11. Degree of relationship of contracting of contracting parties</label>
                <h1 name="mcert_g_marriage_dissolved_relationship" id="mcert_g_marriage_dissolved_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_marriage_dissolved_relationship }}</H1>
              </div> 
            
              <!-- Name of Father -->
              <label class="md:col-span-6">12. Name of Father</label>
                <div class="md:col-span-6">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_fathers_last_name }}, {{ $mcert->mcert_g_fathers_first_name }} {{ $mcert->mcert_g_fathers_middle_name }}</h1>
              </div> 

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_g_fathers_citizenship">13. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_g_fathers_citizenship" id="mcert_g_fathers_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_fathers_citizenship }}</h1>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_g_fathers_residence">14. House No., St., Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_g_fathers_residence" id="mcert_g_fathers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_fathers_residence }}</h1>
              </div>

              <!-- Name of Mother -->
              <label class="md:col-span-6">15. Maiden Name of Mother</label>
                <div class="md:col-span-6">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_mothers_last_name }}, {{ $mcert->mcert_g_mothers_first_name }} {{ $mcert->mcert_g_mothers_middle_name }}</h1>
              </div>

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_g_mothers_citizenship">16. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_g_mothers_citizenship" id="mcert_g_mothers_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_mothers_citizenship }}</h1>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_g_mothers_residence">17. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_g_mothers_residence" id="mcert_g_mothers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_mothers_residence }}</h1>
              </div>

              <!-- Persons who gave consent -->
              <div class="md:col-span-6">
                <label for="mcert_g_consent_given_by">18. Persons who gave consent or advice</label>
                <h1 name="mcert_g_consent_given_by" id="mcert_g_consent_given_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_consent_given_by }}</h1>
              </div>

              <!-- Relationship -->
              <div class="md:col-span-6">
                <label for="mcert_g_consent_given_relationship">19. Relationship</label>
                <h1 name="mcert_g_consent_given_relationship" id="mcert_g_consent_given_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_consent_given_relationship }}</h1>
              </div>

            <!-- Citizenship -->
            <div class="md:col-span-6">
                <label for="mcert_g_consent_given_citizenship">20. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_g_consent_given_citizenship" id="mcert_g_consent_given_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_consent_given_citizenship }}</h1>
                    </div>
              </div>

            <!-- Residence -->
            <div class="md:col-span-6">
                <label for="mcert_g_consent_given_residence">21. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_g_consent_given_residence" id="mcert_g_consent_given_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_g_consent_given_residence  }}</h1>
              </div>
            <br>
              
            </div>
          </div>
        </div>
      </div>
<!-- Bride Data Form -->
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
  <div class="container max-w-screen-lg mx-auto">
    
      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Bride Details</p>
            <p>Please fill out all the fields.</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
            <!-- Name of Applicant -->
            <label class="md:col-span-6">1. Name of Applicant</label>
            <div class="md:col-span-6">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_last_name }}, {{ $mcert->mcert_b_first_name }} {{ $mcert->mcert_b_middle_name }}</h1>      
              </div>
            
            <!-- Date of Birth/Age -->
            <label class="md:col-span-6">2. Date of Birth/Age</label>
            <div class="md:col-span-4">
              <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_date_of_birth }}</h1>
              </div>
            <div class="md:col-span-2">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_age }}</h1>
              </div>

              
             <!-- Place of Birth -->
             <label class="md:col-span-6">3. Place of Birth</label>
            <div class="md:col-span-2">
            <label for="mcert_b_place_of_birth_city">(Municipality/City)</label>
                <h1 name="mcert_b_place_of_birth_city" id="mcert_b_place_of_birth_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_place_of_birth_city }}</h1>
              </div>
            <div class="md:col-span-2">
            <label for="mcert_b_place_of_birth_province">(Province)</label>
                <h1 name="mcert_b_place_of_birth_province" id="mcert_b_place_of_birth_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_place_of_birth_province }}</h1>
              </div>
              <div class="md:col-span-2">
              <label for="mcert_b_place_of_birth_country">(Country)</label>
                <h1 name="mcert_b_place_of_birth_country" id="mcert_b_place_of_birth_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{$mcert->mcert_b_place_of_birth_country}}</h1>
              </div>    
            

            <!-- Sex/Citizenship -->
            <label class="md:col-span-6">4. Sex/Citizenship</label>
            <div class="md:col-span-2">
                <label for="mcert_b_sex">(Male/Female)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_b_sex" id="mcert_b_sex" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_sex }}</h1>    
                    </div>
              </div>

              <div class="md:col-span-4">
                <label for="mcert_b_citizenship">(Citizenship)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_b_citizenship" id="mcert_b_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_citizenship }}</h1>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_b_residence">5. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_b_residence" id="mcert_b_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_residence }}</h1>
              </div>

              <!-- Religion/Religious Sect -->
              <div class="md:col-span-6">
                <label for="mcert_b_religion">6. Religion/Religious Sect</label>
                <h1 name="mcert_b_religion" id="mcert_b_religion" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_religion }}</h1>
              </div>

              <!-- Civil Status -->
              <div class="md:col-span-6">
                <label for="mcert_b_civil_status">7. Civil Status</label>
                <h1 name="mcert_b_civil_status" id="mcert_b_civil_status" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_civil_status }}</H1>
              </div>

              <!-- if Previoulsy Married -->
              <div class="md:col-span-6">
                <label for="mcert_b_marriage_dissolved">8. IF PREVIOUSLY MARRIED: How was it dissolved?</label>
                <h1 name="mcert_b_marriage_dissolved" id="mcert_b_marriage_dissolved" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_marriage_dissolved }}</H1>
              </div>
              
              <!-- Place Where Dissolved -->
              <label class="md:col-span-6">9. Place where dissolved</label>
            <div class="md:col-span-2">
            <label for="mcert_b_marriage_dissolved_place_city">(City/Municipality)</label>
                <h1 name="mcert_b_marriage_dissolved_place_city" id="mcert_b_marriage_dissolved_place_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_marriage_dissolved_place_city }}</h1>
              </div>
            <div class="md:col-span-2">
            <label for="mcert_b_marriage_dissolved_place_province">(Province)</label>
                <h1 name="mcert_b_marriage_dissolved_place_province" id="mcert_b_marriage_dissolved_place_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_marriage_dissolved_place_province }}</h1>
              </div>
              <div class="md:col-span-2">
              <label for="mcert_b_marriage_dissolved_place_country">(Country)</label>
                <h1 name="mcert_b_marriage_dissolved_place_country" id="mcert_b_marriage_dissolved_place_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_marriage_dissolved_place_country }}</h1>
              </div>    

              <!-- Date when dissoved -->
              <div class="md:col-span-6">
              <label for="mcert_b_marriage_dissolved_date">10. Date when dissolved</label>
                <h1 name="mcert_b_marriage_dissolved_date" id="mcert_b_marriage_dissolved_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_marriage_dissolved_date }}</h1>
              </div>

              <!-- Degree of relationship of contracting of contracting parties -->
              <div class="md:col-span-6">
                <label for="mcert_b_marriage_dissolved_relationship">11. Degree of relationship of contracting of contracting parties</label>
                <h1 name="mcert_b_marriage_dissolved_relationship" id="mcert_b_marriage_dissolved_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_marriage_dissolved_relationship }}</H1>
              </div> 
            
              <!-- Name of Father -->
              <label class="md:col-span-6">12. Name of Father</label>
                <div class="md:col-span-6">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_fathers_last_name }}, {{ $mcert->mcert_b_fathers_first_name }} {{ $mcert->mcert_b_fathers_middle_name }}</h1>
              </div> 

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_b_fathers_citizenship">13. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_b_fathers_citizenship" id="mcert_b_fathers_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_fathers_citizenship }}</h1>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_b_fathers_residence">14. House No., St., Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_b_fathers_residence" id="mcert_b_fathers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_fathers_residence }}</h1>
              </div>

              <!-- Name of Mother -->
              <label class="md:col-span-6">15. Maiden Name of Mother</label>
                <div class="md:col-span-6">
                <h1 class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_mothers_last_name }}, {{ $mcert->mcert_b_mothers_first_name }} {{ $mcert->mcert_b_mothers_middle_name }}</h1>
              </div>

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_b_mothers_citizenship">16. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_b_mothers_citizenship" id="mcert_b_mothers_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_mothers_citizenship }}</h1>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_b_mothers_residence">17. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_b_mothers_residence" id="mcert_b_mothers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_mothers_residence }}</h1>
              </div>

              <!-- Persons who gave consent -->
              <div class="md:col-span-6">
                <label for="mcert_b_consent_given_by">18. Persons who gave consent or advice</label>
                <h1 name="mcert_b_consent_given_by" id="mcert_b_consent_given_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_consent_given_by }}</h1>
              </div>

              <!-- Relationship -->
              <div class="md:col-span-6">
                <label for="mcert_b_consent_given_relationship">19. Relationship</label>
                <h1 name="mcert_b_consent_given_relationship" id="mcert_b_consent_given_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_consent_given_relationship }}</h1>
              </div>

            <!-- Citizenship -->
            <div class="md:col-span-6">
                <label for="mcert_b_consent_given_citizenship">20. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <h1 name="mcert_b_consent_given_citizenship" id="mcert_b_consent_given_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_consent_given_citizenship }}</h1>
                    </div>
              </div>

            <!-- Residence -->
            <div class="md:col-span-6">
                <label for="mcert_b_consent_given_residence">21. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <h1 name="mcert_b_consent_given_residence" id="mcert_b_consent_given_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">{{ $mcert->mcert_b_consent_given_residence  }}</h1>
              </div>
            <br>
              
            </div>
          </div>
        </div>
      </div>
                <div class="flex justify-between mt-6">
                    <!-- Download Button -->
          
                    <form action="{{ route('mcerts.generatePDF', $mcert->id) }}" target="_blank" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center h-10 mr-4 rounded-lg bg-gradient-to-tr from-gray-600 to-gray-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                            <span>Export</span>
                        </button>
                    </form>
                   
                    <!-- Edit Button -->
                    <a href="{{ route('mcerts.edit', $mcert) }}">
                    <button type="button" class="flex items-center h-10 mr-4 rounded-lg bg-gradient-to-tr from-yellow-600 to-yellow-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>  
                        <span class="inline-block ml-1">Edit</span>
                    </button>
                    </a> 
                    
                   @can('manage_approval')
                    <div class="flex items-center">
                      
                          <form action="{{ route('mcerts.approve', $mcert) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-green-600 to-green-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 mr-2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                  Approve
                              </button>
                          </form>

                          <form action="{{ route('mcerts.unapprove', $mcert) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-red-600 to-red-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 mr-2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                  Pending
                              </button>
                          </form>
                      
                  </div>
                    @endcan
                
                </div>
                
      </div>
    </div>
@endauth
@endsection



