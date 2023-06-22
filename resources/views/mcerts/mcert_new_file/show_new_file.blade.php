<!-- show.index.blade.php -->


@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">CERTIFICATE OF MARRIAGE</h2>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Details</p>
            <p>Please fill out all the fields.</p>
          </div>

          <div class="grid grid-cols-1 space-y-6">
				<div class="lg:col-span-6">
              		<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
						<div class="md:col-span-6">
							<label for="mcert_new_file_registry_no" class="text-sm font-bold text-gray-500 tracking-wide">Registry No.</label>
							<h1 name="mcert_new_file_registry_no" id="mcert_new_file_registry_no"class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                                {{$mcertNewFile->mcert_new_file_registry_no}}</h1>
						</div>

						<div class="md:col-span-6">
							<label for="mcert_new_file_groom_name" class="text-sm font-bold text-gray-500 tracking-wide">Groom Name</label>
							<h1 name="mcert_new_file_groom_name" id="mcert_new_file_groom_name"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                                {{$mcertNewFile->mcert_new_file_groom_name}}</h1>
						</div>

						<div class="md:col-span-6">
							<label for="mcert_file_bride_name" class="text-sm font-bold text-gray-500 tracking-wide">Bride Name</label>
							<h1 name="mcert_file_bride_name" id="mcert_file_bride_name"  class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                                {{$mcertNewFile->mcert_new_file_bride_name}}</h1>
						</div>

                        <div class="md:col-span-6">
                        <label for="mcert_new_file_attach_document" class="text-sm font-bold text-gray-500 tracking-wide">PDF File</label>
                        <h1 name="mcert_new_file_attach_document" id="mcert_new_file_attach_document" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center left-center text-base">
                          {{$mcertNewFile->mcert_new_file_attach_document}}</h1>
                        </div>

                        <div class="md:col-span-6">
                            <label for="mcert_new_file_path" class="text-sm font-bold text-gray-500 tracking-wide">PDF File</label>
                            <a href="{{ asset('storage/' . $mcertNewFile->mcert_file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            <textarea name="mcert_new_file_path" id="mcert_new_file_path" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center text-base">
                              {{$mcertNewFile->mcert_new_file_path}}</textarea>
                             </a>
                            </div>
                        </div>
                        
					</div>
				</div>
                  
                </div>
              
          </div>

                <div class="flex justify-between mt-6">
                    <!-- Download Button -->
          
                    <a href="#"><button class="flex items-center h-10 mr-4 rounded-lg bg-gradient-to-tr from-gray-600 to-gray-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                    <span>Download</span></button></a>
                   
                    <!-- Edit Button -->
                    <a href="#">
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

@endsection



