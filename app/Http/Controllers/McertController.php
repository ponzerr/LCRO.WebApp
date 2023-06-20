<?php

namespace App\Http\Controllers;


use FPDF;
use Dompdf\Dompdf;
use Aws\S3\S3Client;
use App\Models\Mcert;
use Barryvdh\DomPDF\PDF;
use App\Models\McertFile;
use App\Models\McertAppFile;
use App\Models\McertNewFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class McertController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])->except(['home', 'show']);
    }

    public function index()
    {
        $mcerts = Mcert::orderBy('mcert_registry_no', 'desc')->get();

        // $mcerts = Mcert::with('status')->get();
        // $mcerts = DB::table('mcerts')
        // ->join('status', 'status.mcert_id', '=', 'mcerts.id')
        // ->get();
        // dd($mcerts);
        return view('mcerts.index', ['mcerts' => $mcerts]);
    }

    public function home()
    {
        return view('/home');
    }

    public function create()
    {
       
        return view('mcerts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mcert_registry_no' => 'required',
            'mcert_province' => 'required',
            'mcert_municipality' => 'required',
            'mcert_received_by' => 'required',
            'mcert_date_of_receipt' => 'required|date',
            'mcert_marriage_license_no' => 'required|integer',
            'mcert_date_of_issuance' => 'required|date',
            // new input
            // groom details
            'mcert_g_first_name' => 'required',
            'mcert_g_middle_name' => 'required',
            'mcert_g_last_name' => 'required',
            'mcert_g_date_of_birth' => 'required|date',
            'mcert_g_age' => 'required|integer',
            'mcert_g_place_of_birth_city' => 'required',
            'mcert_g_place_of_birth_province' => 'required',
            'mcert_g_place_of_birth_country' => 'required',
            'mcert_g_sex' => 'required|max:10',
            'mcert_g_citizenship' => 'required',
            'mcert_g_residence' => 'required',
            'mcert_g_religion' => 'required',
            'mcert_g_civil_status' => 'required',
            // if groom marriage dissolved
            // 'mcert_g_marriage_dissolved' =>  '',
            // 'mcert_g_marriage_dissolved_place_city' => '',
            // 'mcert_g_marriage_dissolved_place_province' => '',
            // 'mcert_g_marriage_dissolved_place_country' => '',
            // 'mcert_g_marriage_dissolved_date' => 'date',
            // 'mcert_g_marriage_dissolved_relationship' => '',
            // // // groom father
            // 'mcert_g_fathers_first_name' => '',
            // 'mcert_g_fathers_middle_name' => '',
            // 'mcert_g_fathers_last_name' => '',
            // 'mcert_g_fathers_citizenship' => '',
            // 'mcert_g_fathers_residence' => '',
            // // groom mother
            // 'mcert_g_mothers_first_name' => '',
            // 'mcert_g_mothers_middle_name' => '',
            // 'mcert_g_mothers_last_name' => '',
            // 'mcert_g_mothers_citizenship' => '',
            // 'mcert_g_mothers_residence' => '',
            // // person who gave consent
            // 'mcert_g_consent_given_by' => '',
            // 'mcert_g_consent_given_relationship' => '',
            // 'mcert_g_consent_given_citizenship' => '',
            // 'mcert_g_consent_given_residence' => '',
            // bride details
            'mcert_b_first_name' => 'required',
            'mcert_b_middle_name' => 'required',
            'mcert_b_last_name' => 'required',
            'mcert_b_date_of_birth' => 'required|date',
            'mcert_b_age' => 'required|integer',
            'mcert_b_place_of_birth_city' => 'required',
            'mcert_b_place_of_birth_province' => 'required',
            'mcert_b_place_of_birth_country' => 'required',
            'mcert_b_sex' => 'required|max:10',
            'mcert_b_citizenship' => 'required',
            'mcert_b_residence' => 'required',
            'mcert_b_religion' => 'required',
            'mcert_b_civil_status' => 'required',
            // // if bride marriage dissolved
            // 'mcert_b_marriage_dissolved' => '',
            // 'mcert_b_marriage_dissolved_place_city' => '',
            // 'mcert_b_marriage_dissolved_place_province' => '',
            // 'mcert_b_marriage_dissolved_place_country' => '',
            // 'mcert_b_marriage_dissolved_date' => 'date',
            // 'mcert_b_marriage_dissolved_relationship' => '',
            // // bride father
            // 'mcert_b_fathers_first_name' => '',
            // 'mcert_b_fathers_middle_name' => '',
            // 'mcert_b_fathers_last_name' => '',
            // 'mcert_b_fathers_citizenship' => '',
            // 'mcert_b_fathers_residence' => '',
            // // bride mother
            // 'mcert_b_mothers_first_name' => '',
            // 'mcert_b_mothers_middle_name' => '',
            // 'mcert_b_mothers_last_name' => '',
            // 'mcert_b_mothers_citizenship' => '',
            // 'mcert_b_mothers_residence' => '',
            // // person who gave consent
            // 'mcert_b_consent_given_by' => '',
            // 'mcert_b_consent_given_relationship' => '',
            // 'mcert_b_consent_given_citizenship' => '',
            // 'mcert_b_consent_given_residence' => ''

        ]);

        $mcert = Mcert::create(request()->all());
        // // get the last row of mcert table
        // // $mcert = Mcert::latest()->first();
        // // create status
        // Status::create([
        //     'mcert_id' => $mcert->id,
        //     'status' => false
        //     ]);

        return redirect()->route('mcerts.index', ['mcert' => $mcert])
            ->with('success', 'Marriage Application Created Successfully.');
    }

    public function show(Mcert $mcert)
    {
        //query search
        $mcerts = Mcert::latest()->get();
        
        return view('mcerts.show', compact('mcert'));
    }

    public function edit(Mcert $mcert)
    {
        return view('mcerts.edit', compact('mcert'));
    }

    public function update(Request $request, Mcert $mcert)
    {
        $request->validate([
            'mcert_registry_no' => 'required',
            'mcert_province' => 'required',
            'mcert_municipality' => 'required',
            'mcert_received_by' => 'required',
            'mcert_date_of_receipt' => 'required|date',
            'mcert_marriage_license_no' => 'required|integer',
            'mcert_date_of_issuance' => 'required|date',
            // new input
            // groom details
            'mcert_g_first_name' => 'required',
            'mcert_g_middle_name' => 'required',
            'mcert_g_last_name' => 'required',
            'mcert_g_date_of_birth' => 'required|date',
            'mcert_g_age' => 'required|integer',
            'mcert_g_place_of_birth_city' => 'required',
            'mcert_g_place_of_birth_province' => 'required',
            'mcert_g_place_of_birth_country' => 'required',
            'mcert_g_sex' => 'required|max:10',
            'mcert_g_citizenship' => 'required',
            'mcert_g_residence' => 'required',
            'mcert_g_religion' => 'required',
            'mcert_g_civil_status' => 'required',
            // // if groom marriage dissolved
            // 'mcert_g_marriage_dissolved' =>  '',
            // 'mcert_g_marriage_dissolved_place_city' => '',
            // 'mcert_g_marriage_dissolved_place_province' => '',
            // 'mcert_g_marriage_dissolved_place_country' => '',
            // 'mcert_g_marriage_dissolved_date' => 'date',
            // 'mcert_g_marriage_dissolved_relationship' => '',
            // // // groom father
            // 'mcert_g_fathers_first_name' => '',
            // 'mcert_g_fathers_middle_name' => '',
            // 'mcert_g_fathers_last_name' => '',
            // 'mcert_g_fathers_citizenship' => '',
            // 'mcert_g_fathers_residence' => '',
            // // groom mother
            // 'mcert_g_mothers_first_name' => '',
            // 'mcert_g_mothers_middle_name' => '',
            // 'mcert_g_mothers_last_name' => '',
            // 'mcert_g_mothers_citizenship' => '',
            // 'mcert_g_mothers_residence' => '',
            // // person who gave consent
            // 'mcert_g_consent_given_by' => '',
            // 'mcert_g_consent_given_relationship' => '',
            // 'mcert_g_consent_given_citizenship' => '',
            // 'mcert_g_consent_given_residence' => '',
            // bride details
            'mcert_b_first_name' => 'required',
            'mcert_b_middle_name' => 'required',
            'mcert_b_last_name' => 'required',
            'mcert_b_date_of_birth' => 'required|date',
            'mcert_b_age' => 'required|integer',
            'mcert_b_place_of_birth_city' => 'required',
            'mcert_b_place_of_birth_province' => 'required',
            'mcert_b_place_of_birth_country' => 'required',
            'mcert_b_sex' => 'required|max:10',
            'mcert_b_citizenship' => 'required',
            'mcert_b_residence' => 'required',
            'mcert_b_religion' => 'required',
            'mcert_b_civil_status' => 'required',
            // // if bride marriage dissolved
            // 'mcert_b_marriage_dissolved' => '',
            // 'mcert_b_marriage_dissolved_place_city' => '',
            // 'mcert_b_marriage_dissolved_place_province' => '',
            // 'mcert_b_marriage_dissolved_place_country' => '',
            // 'mcert_b_marriage_dissolved_date' => 'date',
            // 'mcert_b_marriage_dissolved_relationship' => '',
            // // bride father
            // 'mcert_b_fathers_first_name' => '',
            // 'mcert_b_fathers_middle_name' => '',
            // 'mcert_b_fathers_last_name' => '',
            // 'mcert_b_fathers_citizenship' => '',
            // 'mcert_b_fathers_residence' => '',
            // // bride mother
            // 'mcert_b_mothers_first_name' => '',
            // 'mcert_b_mothers_middle_name' => '',
            // 'mcert_b_mothers_last_name' => '',
            // 'mcert_b_mothers_citizenship' => '',
            // 'mcert_b_mothers_residence' => '',
            // // person who gave consent
            // 'mcert_b_consent_given_by' => '',
            // 'mcert_b_consent_given_relationship' => '',
            // 'mcert_b_consent_given_citizenship' => '',
            // 'mcert_b_consent_given_residence' => ''
            
        ]);

        $mcert->update($request->all());

        return redirect()->route('mcerts.index')
            ->with('success', 'Marriage Application Updated Successfully.');
    }

    public function destroy(Mcert $mcert)
    {
        $mcert->delete();

        return redirect()->route('mcerts.index')
            ->with('success', 'Marriage Application deleted successfully.');
    }

    // search function
    public function search(Request $request)
    {
        // dd($request->query);
        $query = $request->input('query');

        // If the query does not match the format, search by other criteria
        $mcerts = Mcert::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('mcert_registry_no', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_g_first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_g_middle_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_g_last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_b_first_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_b_middle_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_b_last_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_status', 'LIKE', '%' . $query . '%')
                ->orWhere('created_at', 'LIKE', '%' . $query . '%');
                // Add more search conditions based on your requirements
        })->get();

        return view('mcerts.index', compact('mcerts'));
    }
    
    
    
    
    //-------------------------------------------------------------------------------------------------------
    
    // insert legacy/old files

    public function index_mcert_old_file () {

        $mcertFiles = McertFile::orderBy('mcert_file_registry_no', 'asc')->get();
        return view('mcerts.mcert_old_file.index_file', ['mcertFiles' => $mcertFiles]);

    }

    public function create_mcert_old_file () {
        return view('mcerts.mcert_old_file.insert_file');
    }

    public function store_mcert_old_file (Request $request) {
        
        $request->validate([
            'mcert_file_registry_no' => 'required',
            'mcert_file_groom_name' => 'required',
            'mcert_file_bride_name' => 'required',
            'mcert_file_attach_document' => 'required',
        ]);
    
        // Create a new instance of the model
        $mcertFile = McertFile::create(request()->all());
    
        // Handle the file upload
        if ($request->hasFile('mcert_file_attach_document')) {
            $file = $request->file('mcert_file_attach_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('mcerts', $filename, 'public'); // Change 'public' to your disk name if different
            $path2 = $file->storeAs('', $filename, 's3'); // storing inside s3 box
            // Set the file path in the model
            $mcertFile->mcert_file_path = $path;
        }
    
        // Save the model to the database
        $mcertFile->save();
    
        return redirect()->route('mcerts.index_file')
            ->with('success', 'Marriage Application stored Successfully.');

        // $file = $request->file('file');
        // $path = $file->store('', 's3');
    }

    public function search_mcert_old_file(Request $request)
    {
        // dd($request->query);
        $query = $request->input('query');

        $mcertFiles = McertFile::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('mcert_file_registry_no', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_file_groom_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_file_bride_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_file_attach_document', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_file_path', 'LIKE', '%' . $query . '%')
                ->orWhere('created_at', 'LIKE', '%' . $query . '%');
                // Add more search conditions based on your requirements
        })->get();

        // $searchQuery = $request->input('query');

        // // AWS SDK configuration
        // $s3 = new S3Client([
        //     'version' => 'latest',
        //     'region' => 'ap-southeast-1',
        //     'credentials' => [
        //         'key' => 'AKIAQQTY5T2ZYJLIW5CB',
        //         'secret' => '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',
        //     ],
        // ]);

        // $bucketName = 'lcro-pdf-result-bucket';
        // $folderPath = '';
        // $results = [];
        // try {
        //     // Get the list of objects in the S3 bucket
        //     $objects = $s3->listObjectsV2([
        //         'Bucket' => $bucketName,
        //         'Prefix' => $folderPath,
        //     ]);

        //     // Iterate through each object and search for the query
        //     foreach ($objects['Contents'] as $object) {
        //         $objectKey = $object['Key'];

        //         // Get the contents of the JSON file from S3
        //         $jsonContent = $s3->getObject([
        //             'Bucket' => $bucketName,
        //             'Key' => $objectKey,
        //         ]);

        //         // Decode the JSON content
        //         $data = json_decode($jsonContent['Body'], true);

        //         // Perform search on the extracted data
        //         // Customize this part based on your extracted JSON structure and search criteria
        //         if (isset($data['Blocks'])) {
        //             foreach ($data['Blocks'] as $block) {
        //                 if ($block['BlockType'] === 'LINE' && isset($block['Text']) && strpos(strtoupper($block['Text']), strtoupper($searchQuery)) !== false) {
        //                     $result = [
        //                         'objectKey' => $objectKey,
        //                         'objectName' => $object['Key'],
        //                         'text' => $block['Text'],
        //                     ];
        //                     $results[] = $result;
        //                     break;
        //                 }
        //             }

        //         }
        //         // dd($results);

        //     }
        //  return view('results', ['results' => $results]);

        // } catch (AwsException $e) {
        //     return back()->with('error', 'An error occurred during the search. Please try again.');
        // }

        return view('mcerts.mcert_old_file.index_file', compact('mcertFiles'));
    }

    public function show_mcert_old_file(McertFile $mcertFile)
    {
        //query search
        $mcertFiles = McertFile::latest()->get();
        
        return view('mcerts.mcert_old_file.show_file', compact('mcertFile'));
    }

    public function destroy_mcert_old_file(McertFile $mcertFile)
    {
            // Get the file path
        $filePath = public_path('storage/' . $mcertFile->mcert_file_path);

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                // File deleted successfully, delete the record from the database
                $mcertFile->delete();

                return redirect()->route('mcerts.index_file')
                    ->with('success', 'Marriage Application deleted successfully.');
            } else {
                // Unable to delete the file
                return redirect()->route('mcerts.index_file')
                    ->with('error', 'Failed to delete the file. Please try again.');
            }
        } else {
            // File doesn't exist
            return redirect()->route('mcerts.index_file')
                ->with('error', 'File not found.');
        }
    }

    public function edit_mcert_old_file(McertFile $mcertFile)
    {
        return view('mcerts.mcert_old_file.edit_file', compact('mcertFile'));
    }
    
    public function update_mcert_old_file(Request $request, McertFile $mcertFile)
    {
        $request->validate([
            'mcert_file_registry_no' => '',
            'mcert_file_groom_name' => '',
            'mcert_file_bride_name' => '',
            'mcert_file_attach_document' => ''
        ]);
    
        // Update the attributes of the McertFile instance with the request data
        $mcertFile->update($request->all());
    
        return redirect()->route('mcerts.index_file')
            ->with('success', 'Marriage Application Updated Successfully.');
    }
    
    //------------------------------------------------------------------------------------------------------- 

    // insert recent/new files
    
    public function index_mcert_new_file () {

        $mcertNewFiles = McertNewFile::orderBy('mcert_new_file_registry_no', 'asc')->get();
        return view('mcerts.mcert_new_file.index_new_file', ['mcertNewFiles' => $mcertNewFiles]);

    }

    public function create_mcert_new_file () {
        return view('mcerts.mcert_new_file.insert_new_file');
    }

    public function store_mcert_new_file(Request $request) {
        $request->validate([
            'mcert_new_file_registry_no' => 'required',
            'mcert_new_file_groom_name' => 'required',
            'mcert_new_file_bride_name' => 'required',
            'mcert_new_file_attach_document' => 'required'
        ]);
    
        // Create a new instance of the model
        $mcertNewFile = McertNewFile::create($request->all());
    
        // Handle the file upload
        if ($request->hasFile('mcert_new_file_attach_document')) {
            $file = $request->file('mcert_new_file_attach_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            dd($filename);
            $path = $file->storeAs('mcerts', $filename, 'public'); // Change 'public' to your disk name if different
            $path2 = $file->storeAs('', $filename, 's3'); // storing inside s3 box

            // Set the file path in the model
            $mcertNewFile->mcert_new_file_path = $path;
        }
    
        // Save the model to the database
        $mcertNewFile->save();
    
        return redirect()->route('mcerts.index_new_file')
            ->with('success', 'Marriage Application stored Successfully.');
    }

    public function search_mcert_new_file(Request $request)
    {
        // dd($request->query);
        $query = $request->input('query');

        $mcertNewFiles = McertNewFile::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('mcert_new_file_registry_no', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_new_file_groom_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_new_file_bride_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_new_file_attach_document', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_new_file_path', 'LIKE', '%' . $query . '%');
                // Add more search conditions based on your requirements
        })->get();

        return view('mcerts.mcert_new_file.index_file', compact('mcertNewFiles'));
    }

    public function show_mcert_new_file(McertNewFile $mcertNewFile)
    {
        //query search
        $mcertNewFiles = McertNewFile::latest()->get();
        
        return view('mcerts.mcert_new_file.show_file', compact('mcertNewFile'));
    }

    public function destroy_mcert_new_file(McertNewFile $mcertNewFile)
    {
        // Get the file path
        $newfilePath = public_path('storage/' . $mcertNewFile->mcert_new_file_path);

        // Delete the file from the directory
        if (file_exists($newfilePath)) {
            unlink($newfilePath);
        }

        $mcertNewFile->delete();

        return redirect()->route('mcerts.index_new_file')
            ->with('success', 'Marriage Application deleted successfully.');
    }

    public function edit_mcert_new_file(McertNewFile $mcertNewFile)
    {
        return view('mcerts.mcert_new_file.edit_new_file', compact('mcertNewFile'));
    }
    
    public function update_mcert_new_file(Request $request, McertNewFile $mcertNewFile)
    {
        $request->validate([
            'mcert_new_file_registry_no' => '',
            'mcert_new_file_groom_name' => '',
            'mcert_new_file_bride_name' => '',
            'mcert_new_file_attach_document' => ''
        ]);
    
        // Update the attributes of the McertFile instance with the request data
        $mcertNewFile->update($request->all());
    
        return redirect()->route('mcerts.index_new_file')
            ->with('success', 'Marriage Application Updated Successfully.');
    }



    //------------------------------------------------------------------------------------------------------- 

    // insert application files
    
    public function index_mcert_app_file () {

        $mcertAppFiles = McertAppFile::orderBy('mcert_app_file_registry_no', 'asc')->get();
        return view('mcerts.mcert_app_file.index_app_file', ['mcertAppFiles' => $mcertAppFiles]);

    }

    public function create_mcert_app_file () {
        return view('mcerts.mcert_app_file.insert_app_file');
    }

    public function store_mcert_app_file(Request $request) {
        $request->validate([
            'mcert_app_file_registry_no' => 'required',
            'mcert_app_file_groom_name' => 'required',
            'mcert_app_file_bride_name' => 'required',
            'mcert_app_file_attach_document' => 'required'
        ]);
    
        // Create a new instance of the model
        $mcertAppFile = McertAppFile::create($request->all());
    
        // Handle the file upload
        if ($request->hasFile('mcert_app_file_attach_document')) {
            $file = $request->file('mcert_app_file_attach_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('mcerts', $filename, 'public'); // Change 'public' to your disk name if different
            $path2 = $file->storeAs('', $filename, 's3'); // storing inside s3 box

            // Set the file path in the model
            $mcertAppFile->mcert_app_file_path = $path;
        }
    
        // Save the model to the database
        $mcertAppFile->save();
    
        return redirect()->route('mcerts.index_app_file')
            ->with('success', 'Marriage Application stored Successfully.');
    }

    public function search_mcert_app_file(Request $request)
    {
        // dd($request->query);
        $query = $request->input('query');

        $mcertAppFiles = McertAppFile::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('mcert_app_file_registry_no', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_app_file_groom_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_app_file_bride_name', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_app_file_attach_document', 'LIKE', '%' . $query . '%')
                ->orWhere('mcert_app_file_path', 'LIKE', '%' . $query . '%');
                // Add more search conditions based on your requirements
        })->get();

        return view('mcerts.mcert_app_file.index_app_file', compact('mcertAppFiles'));
    }

    public function show_mcert_app_file(McertAppFile $mcertAppFile)
    {
        //query search
        $mcertAppFiles = McertAppFile::latest()->get();
        
        return view('mcerts.mcert_app_file.show_app_file', compact('mcertAppFile'));
    }

    public function destroy_mcert_app_file(McertAppFile $mcertAppFile)
    {
        // Get the file path
        $appfilePath = public_path('storage/' . $mcertAppFile->mcert_app_file_path);

        // Delete the file from the directory
        if (file_exists($appfilePath)) {
            unlink($appfilePath);
        }

        $mcertAppFile->delete();

        return redirect()->route('mcerts.index_app_file')
            ->with('success', 'Marriage Application deleted successfully.');
    }

    public function edit_mcert_app_file(McertAppFile $mcertAppFile)
    {
        return view('mcerts.mcert_app_file.edit_app_file', compact('mcertAppFile'));
    }
    
    public function update_mcert_app_file(Request $request, McertAppFile $mcertAppFile)
    {
        $request->validate([
            'mcert_app_file_registry_no' => '',
            'mcert_app_file_groom_name' => '',
            'mcert_app_file_bride_name' => '',
            'mcert_app_file_attach_document' => ''
        ]);
    
        // Update the attributes of the McertFile instance with the request data
        $mcertAppFile->update($request->all());
    
        return redirect()->route('mcerts.index_app_file')
            ->with('success', 'Marriage Application Updated Successfully.');
    }




    
    
    
    
    public function approve(Mcert $mcert)
    {
        if (Gate::allows('manage_approval')) {
            $mcert->approve();
            return redirect()->route('mcerts.index')->with('success', 'Marriage License approved successfully.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function unapprove(Mcert $mcert)
    {

        if (Gate::allows('manage_approval')) {
            $mcert->unapprove();
            return redirect()->route('mcerts.index')->with('error', 'Marriage License still pending.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

}
