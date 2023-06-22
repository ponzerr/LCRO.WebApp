<?php

namespace App\Http\Controllers;

use App\Models\DcertFile;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DcertController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])->except(['home']);
    }

    public function index_dcert_file () {

        $dcertFiles = DcertFile::orderBy('dcert_file_registry_no', 'asc')->get();
        return view('dcerts.index_file', ['dcertFiles' => $dcertFiles]);

    }

    public function create_dcert_file () {
        return view('dcerts.insert_file');
    }

    public function store_dcert_file (Request $request) {
        
        $request->validate([
            'dcert_file_registry_no' => 'required',
            'dcert_file_death_name' => 'required',
            'dcert_file_date_of_death' =>'required|date',
            'dcert_file_attach_document' => 'required',
            
        ]);
    
        // Create a new instance of the model
        $dcertFile = DcertFile::create(request()->all());
    
        // Handle the file upload
        if ($request->hasFile('dcert_file_attach_document')) {
            $file = $request->file('dcert_file_attach_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path2 = $file->storeAs('', $filename, 's3'); // storing inside s3 box
            $path = $file->storeAs('certs', $filename, 'public'); // Change 'public' to your disk name if different
            // Set the file path in the model
            $dcertFile->dcert_file_path = $path;
        }
    
        // Save the model to the database
        $dcertFile->save();
    
        return redirect()->route('dcerts.index_file')
            ->with('success', 'Death Certificate stored Successfully.');

        // $file = $request->file('file');
        // $path = $file->store('', 's3');
    }

    public function search_dcert_file(Request $request)
    {
        // dd($request->query);
        $query = $request->input('query');

        $dcertFiles = DcertFile::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('dcert_file_registry_no', 'LIKE', '%' . $query . '%')
                ->orWhere('dcert_file_death_name', 'LIKE', '%' . $query . '%')
                ->orWhere('dcert_file_attach_document', 'LIKE', '%' . $query . '%')
                ->orWhere('dcert_file_date_of_death', 'LIKE', '%' . $query . '%')
                ->orWhere('dcert_file_path', 'LIKE', '%' . $query . '%');
                // Add more search conditions based on your requirements
        })->get();

        return view('dcerts.index_file', compact('dcertFiles'));
    }

    public function show_dcert_file(DcertFile $dcertFile)
    {
        //query search
        $dcertFiles = DcertFile::latest()->get();
        
        return view('dcerts.show_file', compact('dcertFile'));
    }

    public function destroy_dcert_file(DcertFile $dcertFile)
    {
            // Get the file path
        $filePath = public_path('storage/' . $dcertFile->dcert_file_path);

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                // File deleted successfully, delete the record from the database
                $dcertFile->delete();

                return redirect()->route('dcerts.index_file')
                    ->with('success', 'Death Certificate deleted successfully.');
            } else {
                // Unable to delete the file
                return redirect()->route('dcerts.index_file')
                    ->with('error', 'Failed to delete the file. Please try again.');
            }
        } else {
            $dcertFile->delete();
            // File doesn't exist
            return redirect()->route('dcerts.index_file')
                ->with('error', 'File not found.');
        }
    }

    public function edit_dcert_file(DcertFile $dcertFile)
    {
        return view('dcerts.edit_file', compact('dcertFile'));
    }
    
    public function update_dcert_file(Request $request, DcertFile $dcertFile)
    {
        $request->validate([
            'dcert_file_registry_no' => '',
            'dcert_file_death_name' => '',
            'dcert_file_date_of_death' => 'date',
            'dcert_file_attach_document' => ''
        ]);
    
        // Update the attributes of the DcertFile instance with the request data
        $dcertFile->update($request->all());
    
        return redirect()->route('dcerts.index_file')
            ->with('success', 'Death Certificate Updated Successfully.');
    }
    
    //------------------------------------------------------------------------------------------------------- 
}
