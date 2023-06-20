<!-- resources/views/mcerts/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">APPLICATION FOR MARRIAGE LICENSE</h2>

        <form action="{{ route('mcerts.update', $mcert) }}" method="POST">
            @method('PUT')
            @csrf
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
                      <input type="text" name="mcert_province" id="mcert_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_province }}"/>
                    </div>

                    <div class="md:col-span-2">
                      <label for="mcert_registry_no">Registry No.</label>
                      <input type="text" name="mcert_registry_no" id="mcert_registry_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_registry_no }}"/>
                    </div>

                    <div class="md:col-span-5">
                      <label for="mcert_municipality">City/Municipality</label>
                      <input type="text" name="mcert_municipality" id="mcert_municipality" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_municipality }}"/>
                    </div>

                    <div class="md:col-span-3">
                      <label for="mcert_received_by">Received by</label>
                      <input type="text" name="mcert_received_by" id="mcert_received_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_received_by }}"/>
                    </div>

                    <div class="md:col-span-2">
                      <label for="mcert_marriage_license_no">Marriage License No.</label>
                      <input type="number" name="mcert_marriage_license_no" id="mcert_marriage_license_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_marriage_license_no }}" />
                    </div>

                    <div class="md:col-span-3">
                      <label for="mcert_date_of_receipt">Date of Receipt</label>
                      <input type="date" name="mcert_date_of_receipt" id="mcert_date_of_receipt" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_date_of_receipt }}" />
                    </div>

                    <div class="md:col-span-2">
                      <label for="mcert_date_of_issuance">Date of Issuance of Marriage License</label>
                      <input type="date" name="mcert_date_of_issuance" id="mcert_date_of_issuance" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_date_of_issuance }}" />
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
                <input type="text" name="mcert_g_first_name" id="mcert_g_first_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_first_name }}" placeholder="(First)" />      
                <input type="text" name="mcert_g_middle_name" id="mcert_g_middle_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_middle_name }}" placeholder="(Middle)"/>
                <input type="text" name="mcert_g_last_name" id="mcert_g_last_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_last_name }}" placeholder="(Last)"/>
              </div>
            
            <!-- Date of Birth/Age -->
              <label class="md:col-span-6">2. Date of Birth/Age</label>
            <div class="md:col-span-4">
              <input type="date" name="mcert_g_date_of_birth" id="mcert_g_date_of_birth" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_date_of_birth }}" placeholder="" />
              </div>
            <div class="md:col-span-2">
                <input type="number" name="mcert_g_age" id="mcert_g_age" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_age }}" placeholder="Age" />
              </div>

              
             <!-- Place of Birth -->
             <label class="md:col-span-6">3. Place of Birth</label>
            <div class="md:col-span-2">
                <input type="text" name="mcert_g_place_of_birth_city" id="mcert_g_place_of_birth_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_place_of_birth_city }}" placeholder="Municipality" />
              </div>
            <div class="md:col-span-2">
                <input type="text" name="mcert_g_place_of_birth_province" id="mcert_g_place_of_birth_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_place_of_birth_province }}" placeholder="Province" />
              </div>
              <div class="md:col-span-2">
                <input type="text" name="mcert_g_place_of_birth_country" id="mcert_g_place_of_birth_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$mcert->mcert_g_place_of_birth_country}}" placeholder="Country" />
              </div>    
            

            <!-- Sex/Citizenship -->
            <label class="md:col-span-6">4. Sex/Citizenship</label>
            <div class="md:col-span-2">
                <label for="mcert_g_sex">(Male/Female)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_g_sex" id="mcert_g_sex" value="{{ $mcert->mcert_g_sex }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Sex</option>
                        <option value="Male" {{ $mcert->mcert_g_sex === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $mcert->mcert_g_sex === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $mcert->mcert_g_sex === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <div class="md:col-span-4">
                <label for="mcert_g_citizenship">(Citizenship)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_g_citizenship" id="mcert_g_citizenship" value="{{ $mcert->mcert_g_citizenship }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_g_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_g_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_g_residence">5. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_g_residence" id="mcert_g_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_residence }}" />
              </div>

              <!-- Religion/Religious Sect -->
              <div class="md:col-span-6">
                <label for="mcert_g_religion">6. Religion/Religious Sect</label>
                <input type="text" name="mcert_g_religion" id="mcert_g_religion" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_religion }}" />
              </div>

              <!-- Civil Status -->
              <div class="md:col-span-6">
                <label for="mcert_g_civil_status">7. Civil Status</label>
                <input type="text" name="mcert_g_civil_status" id="mcert_g_civil_status" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_civil_status }}" />
              </div>

              <!-- if Previoulsy Married -->
              <div class="md:col-span-6">
                <label for="mcert_g_marriage_dissolved">8. IF PREVIOUSLY MARRIED: How was it dissolved?</label>
                <input type="text" name="mcert_g_marriage_dissolved" id="mcert_g_marriage_dissolved" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=" {{ $mcert->mcert_g_marriage_dissolved }}" />
              </div>
              
              <!-- Place Where Dissolved -->
              <label class="md:col-span-6">9. Place where dissolved</label>
            <div class="md:col-span-2">
                <input type="text" name="mcert_g_marriage_dissolved_place_city" id="mcert_g_marriage_dissolved_place_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_marriage_dissolved_place_city }}" placeholder="City/Municipality" />
              </div>
            <div class="md:col-span-2">
                <input type="text" name="mcert_g_marriage_dissolved_place_province" id="mcert_g_marriage_dissolved_place_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_marriage_dissolved_place_province }}" placeholder="Province" />
              </div>
              <div class="md:col-span-2">
                <input type="text" name="mcert_g_marriage_dissolved_place_country" id="mcert_g_marriage_dissolved_place_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_marriage_dissolved_place_country }}" placeholder="Country" />
              </div>    

              <!-- Date when dissoved -->
              <div class="md:col-span-6">
              <label for="mcert_g_marriage_dissolved_date">10. Date when dissolved</label>
                <input type="date" name="mcert_g_marriage_dissolved_date" id="mcert_g_marriage_dissolved_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_marriage_dissolved_date }}" />
              </div>

              <!-- Degree of relationship of contracting of contracting parties -->
              <div class="md:col-span-6">
                <label for="mcert_g_marriage_dissolved_relationship">11. Degree of relationship of contracting of contracting parties</label>
                <input type="text" name="mcert_g_marriage_dissolved_relationship" id="mcert_g_marriage_dissolved_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_marriage_dissolved_relationship }}" />
              </div> 
            
              <!-- Name of Father -->
              <label class="md:col-span-6">12. Name of Father</label>
                <div class="md:col-span-2">
                <input type="text" name="mcert_g_fathers_first_name" id="mcert_g_fathers_first_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_fathers_first_name }}" placeholder="First" />
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_g_fathers_middle_name" id="mcert_g_fathers_middle_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_fathers_middle_name }}" placeholder="Middle" />
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_g_fathers_last_name" id="mcert_g_fathers_last_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_fathers_last_name }}" placeholder="Last" />
              </div>    

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_g_fathers_citizenship">13. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_g_fathers_citizenship" id="mcert_g_fathers_citizenship" value="{{ $mcert->mcert_g_fathers_citizenship }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_g_fathers_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_g_fathers_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_g_fathers_residence">14. House No., St., Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_g_fathers_residence" id="mcert_g_fathers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_fathers_residence }}" />
              </div>

              <!-- Name of Mother -->
              <label class="md:col-span-6">15. Maiden Name of Mother</label>
                <div class="md:col-span-2">
                <input type="text" name="mcert_g_mothers_first_name" id="mcert_g_mothers_first_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_mothers_first_name }}" placeholder="First" />
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_g_mothers_middle_name" id="mcert_g_mothers_middle_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_mothers_middle_name }}" value="" placeholder="Middle" /> 
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_g_mothers_last_name" id="mcert_g_mothers_last_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_mothers_last_name }}" placeholder="Last" />
              </div>    

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_g_mothers_citizenship">16. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_g_mothers_citizenship" id="mcert_g_mothers_citizenship" value="{{ $mcert->mcert_g_mothers_citizenship }}" placeholder="Citizenship"class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_g_mothers_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_g_mothers_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_g_mothers_residence">17. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_g_mothers_residence" id="mcert_g_mothers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_mothers_residence }}" />
              </div>

              <!-- Persons who gave consent -->
              <div class="md:col-span-6">
                <label for="mcert_g_consent_given_by">18. Persons who gave consent or advice</label>
                <input type="text" name="mcert_g_consent_given_by" id="mcert_g_consent_given_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_consent_given_by }}" />
              </div>

              <!-- Relationship -->
              <div class="md:col-span-6">
                <label for="mcert_g_consent_given_relationship">19. Relationship</label>
                <input type="text" name="mcert_g_consent_given_relationship" id="mcert_g_consent_given_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=" {{ $mcert->mcert_g_consent_given_relationship }}" />
              </div>

            <!-- Citizenship -->
            <div class="md:col-span-6">
                <label for="mcert_g_consent_given_citizenship">20. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_g_consent_given_citizenship" id="mcert_g_consent_given_citizenship" value="{{ $mcert->mcert_g_consent_given_citizenship }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_g_consent_given_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_g_consent_given_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

            <!-- Residence -->
            <div class="md:col-span-6">
                <label for="mcert_g_consent_given_residence">21. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_g_consent_given_residence" id="mcert_g_consent_given_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_g_consent_given_residence  }}" />
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
                <input type="text" name="mcert_b_first_name" id="mcert_b_first_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_first_name }}" placeholder="(First)" />      
                <input type="text" name="mcert_b_middle_name" id="mcert_b_middle_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_middle_name }}" placeholder="(Middle)"/>
                <input type="text" name="mcert_b_last_name" id="mcert_b_last_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_last_name }}" placeholder="(Last)"/>
              </div>
            
            <!-- Date of Birth/Age -->
              <label class="md:col-span-6">2. Date of Birth/Age</label>
            <div class="md:col-span-4">
              <input type="date" name="mcert_b_date_of_birth" id="mcert_b_date_of_birth" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_date_of_birth }}" placeholder="" />
              </div>
            <div class="md:col-span-2">
                <input type="number" name="mcert_b_age" id="mcert_b_age" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_age }}" placeholder="Age" />
              </div>

              
             <!-- Place of Birth -->
             <label class="md:col-span-6">3. Place of Birth</label>
            <div class="md:col-span-2">
                <input type="text" name="mcert_b_place_of_birth_city" id="mcert_b_place_of_birth_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_place_of_birth_city }}" placeholder="Municipality" />
              </div>
            <div class="md:col-span-2">
                <input type="text" name="mcert_b_place_of_birth_province" id="mcert_b_place_of_birth_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_place_of_birth_province }}" placeholder="Province" />
              </div>
              <div class="md:col-span-2">
                <input type="text" name="mcert_b_place_of_birth_country" id="mcert_b_place_of_birth_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$mcert->mcert_b_place_of_birth_country}}" placeholder="Country" />
              </div>    
            

            <!-- Sex/Citizenship -->
            <label class="md:col-span-6">4. Sex/Citizenship</label>
            <div class="md:col-span-2">
                <label for="mcert_b_sex">(Male/Female)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_b_sex" id="mcert_b_sex" value="{{ $mcert->mcert_b_sex }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Sex</option>
                        <option value="Male" {{ $mcert->mcert_g_sex === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $mcert->mcert_g_sex === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $mcert->mcert_g_sex === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <div class="md:col-span-4">
                <label for="mcert_b_citizenship">(Citizenship)</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_b_citizenship" id="mcert_b_citizenship" value="{{ $mcert->mcert_b_citizenship }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_b_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_b_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_b_residence">5. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_b_residence" id="mcert_b_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_residence }}" />
              </div>

              <!-- Religion/Religious Sect -->
              <div class="md:col-span-6">
                <label for="mcert_b_religion">6. Religion/Religious Sect</label>
                <input type="text" name="mcert_b_religion" id="mcert_b_religion" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_religion }}" />
              </div>

              <!-- Civil Status -->
              <div class="md:col-span-6">
                <label for="mcert_b_civil_status">7. Civil Status</label>
                <input type="text" name="mcert_b_civil_status" id="mcert_b_civil_status" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_civil_status }}" />
              </div>

              <!-- if Previoulsy Married -->
              <div class="md:col-span-6">
                <label for="mcert_b_marriage_dissolved">8. IF PREVIOUSLY MARRIED: How was it dissolved?</label>
                <input type="text" name="mcert_b_marriage_dissolved" id="mcert_b_marriage_dissolved" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=" {{ $mcert->mcert_b_marriage_dissolved }}" />
              </div>
              
              <!-- Place Where Dissolved -->
              <label class="md:col-span-6">9. Place where dissolved</label>
            <div class="md:col-span-2">
                <input type="text" name="mcert_b_marriage_dissolved_place_city" id="mcert_b_marriage_dissolved_place_city" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_marriage_dissolved_place_city }}" placeholder="City/Municipality" />
              </div>
            <div class="md:col-span-2">
                <input type="text" name="mcert_b_marriage_dissolved_place_province" id="mcert_b_marriage_dissolved_place_province" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_marriage_dissolved_place_province }}" placeholder="Province" />
              </div>
              <div class="md:col-span-2">
                <input type="text" name="mcert_b_marriage_dissolved_place_country" id="mcert_b_marriage_dissolved_place_country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_marriage_dissolved_place_country }}" placeholder="Country" />
              </div>    

              <!-- Date when dissoved -->
              <div class="md:col-span-6">
              <label for="mcert_b_marriage_dissolved_date">10. Date when dissolved</label>
                <input type="date" name="mcert_b_marriage_dissolved_date" id="mcert_b_marriage_dissolved_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_marriage_dissolved_date }}" />
              </div>

              <!-- Degree of relationship of contracting of contracting parties -->
              <div class="md:col-span-6">
                <label for="mcert_b_marriage_dissolved_relationship">11. Degree of relationship of contracting of contracting parties</label>
                <input type="text" name="mcert_b_marriage_dissolved_relationship" id="mcert_b_marriage_dissolved_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_marriage_dissolved_relationship }}" />
              </div> 
            
              <!-- Name of Father -->
              <label class="md:col-span-6">12. Name of Father</label>
                <div class="md:col-span-2">
                <input type="text" name="mcert_b_fathers_first_name" id="mcert_b_fathers_first_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_fathers_first_name }}" placeholder="First" />
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_b_fathers_middle_name" id="mcert_b_fathers_middle_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_fathers_middle_name }}" placeholder="Middle" />
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_b_fathers_last_name" id="mcert_b_fathers_last_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_fathers_last_name }}" placeholder="Last" />
              </div>    

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_b_fathers_citizenship">13. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_b_fathers_citizenship" id="mcert_b_fathers_citizenship" value="{{ $mcert->mcert_b_fathers_citizenship }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_b_fathers_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_b_fathers_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_b_fathers_residence">14. House No., St., Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_b_fathers_residence" id="mcert_b_fathers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_fathers_residence }}" />
              </div>

              <!-- Name of Mother -->
              <label class="md:col-span-6">15. Maiden Name of Mother</label>
                <div class="md:col-span-2">
                <input type="text" name="mcert_b_mothers_first_name" id="mcert_b_mothers_first_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_mothers_first_name }}" placeholder="First" />
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_b_mothers_middle_name" id="mcert_b_mothers_middle_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_mothers_middle_name }}" value="" placeholder="Middle" /> 
              </div>
                <div class="md:col-span-2">
                <input type="text" name="mcert_b_mothers_last_name" id="mcert_b_mothers_last_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_mothers_last_name }}" placeholder="Last" />
              </div>    

              <!-- Citizenship -->
              <div class="md:col-span-6">
                <label for="mcert_b_mothers_citizenship">16. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_b_mothers_citizenship" id="mcert_b_mothers_citizenship" value="{{ $mcert->mcert_b_mothers_citizenship }}" placeholder="Citizenship"class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_b_mothers_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_b_mothers_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

              <!-- Residence -->
              <div class="md:col-span-6">
                <label for="mcert_b_mothers_residence">17. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_b_mothers_residence" id="mcert_b_mothers_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_mothers_residence }}" />
              </div>

              <!-- Persons who gave consent -->
              <div class="md:col-span-6">
                <label for="mcert_b_consent_given_by">18. Persons who gave consent or advice</label>
                <input type="text" name="mcert_b_consent_given_by" id="mcert_b_consent_given_by" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_consent_given_by }}" />
              </div>

              <!-- Relationship -->
              <div class="md:col-span-6">
                <label for="mcert_b_consent_given_relationship">19. Relationship</label>
                <input type="text" name="mcert_b_consent_given_relationship" id="mcert_b_consent_given_relationship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=" {{ $mcert->mcert_b_consent_given_relationship }}" />
              </div>

            <!-- Citizenship -->
            <div class="md:col-span-6">
                <label for="mcert_b_consent_given_citizenship">20. Citizenship</label>
                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                    <select name="mcert_b_consent_given_citizenship" id="mcert_b_consent_given_citizenship" value="{{ $mcert->mcert_b_consent_given_citizenship }}" class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent">
                        <option value="" disabled selected>Citizenship</option>
                        <option value="Filipino" {{ $mcert->mcert_b_consent_given_citizenship === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                        <option value="Other" {{ $mcert->mcert_b_consent_given_citizenship === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    </div>
              </div>

            <!-- Residence -->
            <div class="md:col-span-6">
                <label for="mcert_b_consent_given_residence">21. House No., St., , Barangay., City/Municipality, Province, Country</label>
                <input type="text" name="mcert_b_consent_given_residence" id="mcert_b_consent_given_residence" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $mcert->mcert_b_consent_given_residence  }}" />
              </div>
            <br>
              
            </div>
          </div>
        </div>
      </div>
                
                <div class="flex justify-end">
                  <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                </div>

        </form>
      </div>
    </div>

@endsection

