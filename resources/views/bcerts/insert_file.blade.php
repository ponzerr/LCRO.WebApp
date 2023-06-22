@extends('layouts.app')

@section('content')

<div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">CERTIFICATE OF BIRTH</h2>

		<div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Details</p>
            <p>Please fill out all the fields.</p>
            <p>*Legacy Files</p>
          </div>
    <form class="mt-8 space-y-3" action="{{ route('bcerts.pdf.file') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-1 space-y-6">
        <div class="lg:col-span-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
            <div class="md:col-span-6">
              <label for="bcert_file_registry_no" class="text-sm font-bold text-gray-500 tracking-wide">Birth Registery No.</label>
              <input type="text" name="bcert_file_registry_no" id="bcert_file_registry_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" required/>
            </div>
            <div class="md:col-span-6">
              <label for="bcert_file_birth_name" class="text-sm font-bold text-gray-500 tracking-wide">Birth Name</label>
              <input type="text" name="bcert_file_birth_name" id="bcert_file_birth_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" required/>
            </div>
            
            <div class="md:col-span-6">
              <label for="bcert_file_date_of_birth" class="text-sm font-bold text-gray-500 tracking-wide">Date of Birth</label>
              <input type="date" name="bcert_file_date_of_birth" id="bcert_file_date_of_birth" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" required/>
            </div>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-1 space-y-2">
        <label class="text-sm font-bold text-gray-500 tracking-wide">Attach Document</label>
        <div class="border-2 border-gray-300 border-dashed rounded-md p-4">
          <div class="text-center">
            <p class="mt-2 text-sm text-gray-500">select a file from your computer</p>
          </div>
          <div class="mt-4 mb-2 flex justify-center items-center">
            <input name="bcert_file_attach_document" type="file" class="" id="bcert_file_attach_document" />
          </div>
        </div>
        <p class="text-sm text-gray-300">
          <span>File type: doc & pdf</span>
        </p>
        <div>
          <button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
            Upload
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection