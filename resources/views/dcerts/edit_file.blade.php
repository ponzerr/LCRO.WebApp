<!-- resources/views/dcerts/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6 mt-1 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <p class="text-gray-500 text-m text-center">Republic of the Philippines</p>
        <p class="text-gray-500 text-m text-center">OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
        <h2 class="font-semibold text-3xl mb-6 text-gray-600 text-center">CERTIFICATE OF DEATH</h2>

		<div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg">Details</p>
            <p>Please edit out all the necessary fields.</p>
          </div>

        <form class="mt-8 space-y-3" action="{{ route('dcerts.update_file', $dcertFile) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="grid grid-cols-1 space-y-6">
				<div class="lg:col-span-6">
              		<div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
						<div class="md:col-span-6">
							<label for="dcert_file_registry_no" class="text-sm font-bold text-gray-500 tracking-wide">Death Registery No.</label>
							<input type="text" name="dcert_file_registry_no" id="dcert_file_registry_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
              value="{{ $dcertFile->dcert_file_registry_no }}" placeholder=""/>
						</div>

						<div class="md:col-span-6">
							<label for="dcert_file_death_name" class="text-sm font-bold text-gray-500 tracking-wide">Death Name</label>
							<input type="text" name="dcert_file_death_name" id="dcert_file_death_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
              value="{{ $dcertFile->dcert_file_death_name }}" placeholder=""/>
						</div>
						
						<div class="md:col-span-6">
							<label for="dcert_file_date_of_death" class="text-sm font-bold text-gray-500 tracking-wide">Date of Death</label>
							<input type="date" name="dcert_file_date_of_death" id="dcert_file_date_of_death" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
              value="{{ $dcertFile->dcert_file_date_of_death }}" placeholder=""/>
						</div>
					</div>
				</div>
			</div>
			<div class="grid grid-cols-1 space-y-2">
				<label class="text-sm font-bold text-gray-500 tracking-wide">Attached Document</label>
					<div class="md:col-span-6">
                            <label for="dcert_file_path" class="text-sm font-bold text-gray-500 tracking-wide">PDF File</label>
                            <a href="{{ asset('dcerts/' . $dcertFile->dcert_file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            <textarea name="dcert_file_path" id="dcert_file_path" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100 flex items-center text-base">{{$dcertFile->dcert_file_path}}</textarea>
                             </a>
                    </div>
                        
          	</div>
			  <div>
				<button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
					Update
				</button>
			</div>
				</div>
			
			<!-- <input type="file" name="file" id="" class="" accept=".pdf"> -->
		</form>
	</div>
</div>


@endsection

