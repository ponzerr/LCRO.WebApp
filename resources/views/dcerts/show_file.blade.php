<!-- show.index.blade.php -->


@extends('layouts.app')

@section('content')
@auth
<div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">CERTIFICATE OF DEATH</h2>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Details</p>
          </div>

          <div class="grid grid-cols-1 space-y-6">
				<div class="lg:col-span-6">
              		<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
						<div class="md:col-span-6">
							<label for="dcert_file_registry_no" class="text-sm font-bold text-gray-500 tracking-wide">Registry No.</label>
							<h1 name="dcert_file_registry_no" id="dcert_file_registry_no" id="dcert_b_mothers_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                                {{$dcertFile->dcert_file_registry_no}}</h1>
						</div>

						<div class="md:col-span-6">
							<label for="dcert_file_death_name" class="text-sm font-bold text-gray-500 tracking-wide">Death Name</label>
							<h1 name="dcert_file_death_name" id="dcert_file_death_name" id="dcert_b_mothers_citizenship" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                                {{$dcertFile->dcert_file_death_name}}</h1>
						</div>

            <div class="md:col-span-6">
							<label for="dcert_file_date_of_death" class="text-sm font-bold text-gray-500 tracking-wide">Date of Death</label>
							<h1 name="dcert_file_date_of_death" id="dcert_file_date_of_death" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                {{$dcertFile->dcert_file_date_of_death}}</h1>
            </div>
                        <div class="md:col-span-6">
							<label for="dcert_file_attach_document" class="text-sm font-bold text-gray-500 tracking-wide">PDF File</label>
							<h1 name="dcert_file_attach_document" id="dcert_file_attach_document" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base" value="" placeholder="">{{$dcertFile->dcert_file_attach_document}}</h1>
                        </div>

                        <div class="md:col-span-6">
                            <label for="dcert_file_path" class="text-sm font-bold text-gray-500 tracking-wide">PDF File</label>
                            <a href="{{ asset('storage/' . $dcertFile->dcert_file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            <textarea name="dcert_file_path" id="dcert_file_path" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center text-base">{{$dcertFile->dcert_file_path}}</textarea>
                             </a>
                            </div>
                        </div>
                        
					</div>
				</div>
                  
                </div>
              
          </div>

                <div class="flex justify-between mt-6">
                    <!-- Edit Button -->
                    <a href="{{ route('dcerts.edit_file', $dcertFile) }}">
                    <button type="button" class="flex items-center h-10 mr-4 rounded-lg bg-gradient-to-tr from-yellow-600 to-yellow-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>  
                        <span class="inline-block ml-1">Edit</span>
                    </button>
                    </a> 
                
                </div>
                
      </div>
    </div>
@endauth
@endsection



