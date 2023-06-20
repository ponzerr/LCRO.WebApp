<!-- resources/views/mcerts/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="flex flex-col justify-left items-left mx-1 mt-4">
    <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-xl mb-2 text-gray-600 text-center">APPLICATION FOR MARRIAGE LICENSE</h2>
      <div class="flex items-center justify-center mx-8">
        
          <!-- add certificate button
          <a href="{{ route('mcerts.create') }}" class="ml-2 inline-block">
            <button type="button" class="flex items-center mr-4 rounded-lg bg-gradient-to-tr from-blue-600 to-blue-400 py-3 px-6 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-5 w-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              <span>Add Certificate</span>
            </button>
          </a> -->
          
          <!-- upload file button -->
          <a href="{{ route('mcerts.pdf_app') }}" class="ml-2 inline-block">
            <button type="button" class="flex items-center mr-4 rounded-lg bg-gradient-to-tr from-pink-600 to-pink-400 py-3 px-6 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-pink-500/20 transition-all hover:shadow-lg hover:shadow-pink-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-5 w-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path>
              </svg>
              <span>Add Files</span>
            </button>
          </a>
      </div>

      <!-- Date filter -->
      <div class="flex items-center justify-center mx-8 mt-2">
          <div class="mr-1">
          <form action="{{ route('generate-approved-report') }}" method="POST">
            @csrf
            <div class="w-23">
                <input
                type="date"
                name="start_date"
                id="start_date"
                class="mb-2 w-23 px-3 py-2 text-sm leading-5 rounded-lg border border-gray-300 outline-none"
                type="text"
                />
            </div>
            </div>
            <div class="mr-1">
            <div class="w-23">
                <input
                type="date"
                name="end_date"
                id="end_date"
                class="mb-1 w-23 px-2 py-2 text-sm leading-5 rounded-lg border border-gray-300 outline-none"
                type="text"
                />
            </div>
          </div>
          <button
            type="submit"
            class="flex select-none gap-3 rounded-lg border border-pink-500 py-2 px-2 text-center font-sans text-xs font-bold uppercase text-pink-500 transition-all hover:opacity-75 focus:ring focus:ring-pink-200 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
            type="button"
            data-ripple-dark="true"
          >
            Generate Report
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-1"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
              ></path>
            </svg>
          </button>
          </form>
</div>

      @if (session('success'))
    <div
        class="mt-4 font-regular relative w-full rounded-lg bg-green-500 px-4 py-4 text-base text-white"
        data-dismissible="alert"
      >
        <div class="absolute top-4 left-4">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
            class="mt-px h-6 w-6"
          >
            <path
              fill-rule="evenodd"
              d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </div>
        <div class="ml-8 mr-12">
          <h5 class="block font-sans text-xl font-semibold leading-snug tracking-normal text-white antialiased">
            Success
          </h5>
          <p class="mt-2 block font-sans text-base font-normal leading-relaxed text-white antialiased">
          {{ session('success') }}
          </p>
        </div>
        <div
          data-dismissible-target="alert"
          data-ripple-dark="true"
          class="absolute top-3 right-3 w-max rounded-lg transition-all hover:bg-white hover:bg-opacity-20"
        >
          <div role="button" class="w-max rounded-lg p-1">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
          </div>
        </div>
      </div>
    @endif

  <div class="w-full mx-auto px-8 mt-4">
    <!-- <div class="inline-block min-w-full py-2 sm:px-6"> -->
      <div class="overflow-x-auto">
        <table class="w-full table-auto text-left text-sm font-light bg-white border border-gray-300">
          <thead class="border-b bg-white font-medium">
            <tr>
              <th scope="col" class="px-6 py-3 text-center">Marriage Registry No.</th>
              <th scope="col" class="px-6 py-3 text-center">Groom</th>
              <th scope="col" class="px-6 py-3 text-center">Bride</th>
              <th scope="col" class="px-6 py-3 text-center">Document</th>
              <!-- Add more table headers for other fields -->
              <th scope="col" class="px-6 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @if($mcertAppFiles->count()) 
              @foreach ($mcertAppFiles as $mcertAppFile)
                <tr class="border-b bg-neutral-100">
                  <th class="whitespace-nowrap px-6 py-2 text-center">{{ $mcertAppFile->mcert_app_file_registry_no }}</th>
                  <th class="whitespace-nowrap px-6 py-2 text-center">{{ $mcertAppFile->mcert_app_file_groom_name }}</th>
                  <th class="whitespace-nowrap px-6 py-2 text-center"><p>{{ $mcertAppFile->mcert_app_file_bride_name }}</p></th>
                  <th class="whitespace-nowrap px-6 py-2 text-center"><p>{{ $mcertAppFile->mcert_app_file_attach_document }}</p></th>
                  <!-- Add more table cells for other fields -->
                  <th class="whitespace-nowrap px-6 py-2 text-center">
                    <!-- show button -->
                    <a href="{{ route('mcerts.show_app_file', $mcertAppFile) }}" class="inline-block mb-1 ml-4">
                      <button type="button" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-blue-600 to-blue-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                        </svg>
                        <span class="inline-block ml-1">Open</span>
                      </button>
                    </a>
                    <br>
                    <!-- edit button -->
                    <a href="{{ route('mcerts.edit_app_file', $mcertAppFile) }}" class="inline-block mb-1 ml-4">
                      <button type="button" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-yellow-600 to-yellow-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>  
                        <span class="inline-block ml-1">Edit</span>
                      </button>
                    </a>
                    <br>
                    <!-- delete button -->
                    <form action="{{ route('mcerts.destroy_app_file', $mcertAppFile) }}" class="inline-block mb-1 ml-4" method="POST" onsubmit="return confirm('Are you sure you want to delete this Mcert?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="flex items-center h-10 w-28 mr-4 rounded-lg bg-gradient-to-tr from-red-600 to-red-400 py-3 px-4 text-center font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-4 w-4 mr-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        <span>Delete</span>
                      </button>
                    </form>
                  </th>

                </tr>
              @endforeach
           @else
              <tr>
                <td colspan="5" class="py-4 text-center">No records found.</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
