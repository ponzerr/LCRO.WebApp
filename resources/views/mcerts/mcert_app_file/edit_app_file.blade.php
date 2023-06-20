<!-- resources/views/mcerts/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div data-tab-content="" class="p-5">
      <div class="block opacity-100" id="app" role="tabpanel">

	  <div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
	<div class="sm:max-w-lg w-full p-10 bg-white rounded-xl">
		<div class="text-center">
			<p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
			<p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
			<h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">APPLICATION FOR MARRIAGE LICENSE</h2>
		</div>

        <form action="{{ route('mcerts.update_app_file', $mcertAppFile) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="grid grid-cols-1 space-y-6">
				<div class="lg:col-span-6">
              		<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
						<div class="md:col-span-6">
							<label for="mcert_app_file_registry_no" class="text-sm font-bold text-gray-500 tracking-wide">Marriage Registery No.</label>
							<input type="text" name="mcert_app_file_registry_no" id="mcert_app_file_registry_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
              					value="{{ $mcertAppFile->mcert_app_file_registry_no }}" placeholder=""/>
						</div>

						<div class="md:col-span-6">
							<label for="mcert_app_file_groom_name" class="text-sm font-bold text-gray-500 tracking-wide">Groom Name</label>
							<input type="text" name="mcert_app_file_groom_name" id="mcert_app_file_groom_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
             					 value="{{ $mcertAppFile->mcert_app_file_groom_name }}" placeholder=""/>
						</div>

						<div class="md:col-span-6">
							<label for="mcert_app_file_bride_name" class="text-sm font-bold text-gray-500 tracking-wide">Bride Name</label>
							<input type="text" name="mcert_app_file_bride_name" id="mcert_app_file_bride_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
              value="{{ $mcertAppFile->mcert_app_file_bride_name }}" placeholder=""/>
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
						<input name="mcert_file_attach_document" type="file" value="{{ $mcertFile->mcert_file_path }}" class=" " id="mcert_file_attach_document" />
          </div>
				</div>
			<p class="text-sm text-gray-300">
				<span>File type: doc & pdf</span>
			</p> 
			<!-- <input type="file" name="file" id="" class="" accept=".pdf"> -->

			<div>
				<button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
					Update
				</button>
			</div>
		</form>
	</div>
</div>

</div>

</div>
  </div>
</div>

@endsection

