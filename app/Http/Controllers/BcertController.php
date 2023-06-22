<?php

namespace App\Http\Controllers;

use App\Models\BcertFile;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BcertController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified'])->except(['home']);
    }

    public function index_bcert_file () {

        $bcertFiles = BcertFile::orderBy('bcert_file_registry_no', 'desc')->get();
        return view('bcerts.index_file', ['bcertFiles' => $bcertFiles]);

    }

    public function create_bcert_file () {
        return view('bcerts.insert_file');
    }

    public function store_bcert_file (Request $request) {
        
        $request->validate([
            'bcert_file_registry_no' => 'required',
            'bcert_file_birth_name' => 'required',
            'bcert_file_date_of_birth' =>'required|date',
            'bcert_file_attach_document' => 'required',
            
        ]);
    
        // Create a new instance of the model
        $bcertFile = BcertFile::create(request()->all());
    
        // Handle the file upload
        if ($request->hasFile('bcert_file_attach_document')) {
            $file = $request->file('bcert_file_attach_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path2 = $file->storeAs('', $filename, 's3'); // storing inside s3 box
            $path = $file->storeAs('certs', $filename, 'public'); // Change 'public' to your disk name if different
            // Set the file path in the model
            $bcertFile->bcert_file_path = $path;
        }
    
        // Save the model to the database
        $bcertFile->save();
    
        return redirect()->route('bcerts.index_file')
            ->with('success', 'Birth Certificate stored Successfully.');

        // $file = $request->file('file');
        // $path = $file->store('', 's3');
    }

    public function search_bcert_file(Request $request)
    {
        // dd($request->query);
        $query = $request->input('query');

        $bcertFiles = BcertFile::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('bcert_file_registry_no', 'LIKE', '%' . $query . '%')
                ->orWhere('bcert_file_birth_name', 'LIKE', '%' . $query . '%')
                ->orWhere('bcert_file_attach_document', 'LIKE', '%' . $query . '%')
                ->orWhere('bcert_file_date_of_birth', 'LIKE', '%' . $query . '%')
                ->orWhere('bcert_file_path', 'LIKE', '%' . $query . '%');
                // Add more search conditions based on your requirements
        })->get();

        return view('bcerts.index_file', compact('bcertFiles'));
    }

    public function show_bcert_file(BcertFile $bcertFile)
    {
        //query search
        $bcertFiles = BcertFile::latest()->get();
        
        return view('bcerts.show_file', compact('bcertFile'));
    }

    public function destroy_bcert_file(BcertFile $bcertFile)
    {
            // Get the file path
        $filePath = public_path('storage/' . $bcertFile->bcert_file_path);

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                // File deleted successfully, delete the record from the database
                $bcertFile->delete();

                return redirect()->route('bcerts.index_file')
                    ->with('success', 'Birth Certificate deleted successfully.');
            } else {
                // Unable to delete the file
                return redirect()->route('bcerts.index_file')
                    ->with('error', 'Failed to delete the file. Please try again.');
            }
        } else {
            $bcertFile->delete();
            // File doesn't exist
            return redirect()->route('bcerts.index_file')
                ->with('error', 'File not found.');
        }
    }

    public function edit_bcert_file(BcertFile $bcertFile)
    {
        return view('bcerts.edit_file', compact('bcertFile'));
    }
    
    public function update_bcert_file(Request $request, BcertFile $bcertFile)
    {
        $request->validate([
            'bcert_file_registry_no' => '',
            'bcert_file_birth_name' => '',
            'bcert_file_date_of_birth' => 'date',
            'bcert_file_attach_document' => ''
        ]);
    
        // Update the attributes of the BcertFile instance with the request data
        $bcertFile->update($request->all());
    
        return redirect()->route('bcerts.index_file')
            ->with('success', 'Birth Certificate Updated Successfully.');
    }
    
    //------------------------------------------------------------------------------------------------------- 
}
