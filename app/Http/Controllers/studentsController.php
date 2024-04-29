<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\students;
use App\Models\table_logs;
use App\Models\SmsApi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Rules\PhilippinePhoneNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http; 

class studentsController extends Controller
{
    public function index(){
      return view('students');
  }

  public function student_logs(){
    return view('student_logs');
}

public function fetchAccounts() {
    
    $api = DB::table('students')->get();

    $output = ''; // Initialize the $output variable

    if ($api->count() > 0) {
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead  class="text-dark">  
                <tr>
                    <th>ID</th>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Parent Number</th>
                    <th>Grade</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($api as $rs) {
            $output .= '<tr>
                <td>' . $rs->id . '</td>
                <td class="align-items-center"><img style="cursor: pointer;" onclick="openImageViewer(\'storage/images/' . $rs->Image . '\')" src="storage/images/' . $rs->Image . '" class="rounded-circle wh-50"><span class="fw-medium fs-15 ms-3">' . $rs->Student_Number . '</span></td>
                <td>' . $rs->Name . '</td>
                <td>' . $rs->Parent_Name . '</td>
                <td>' . $rs->Parent_Number . '</td>
                <td>' . $rs->Grade . '</td>
                <td>' . $rs->Address . '</td>
                <td>
                <button id="' . $rs->id . '" data-studentid="' . $rs->Student_Number . '" data-name="' . $rs->Name . '" name="download" class="icon border-0 rounded-circle text-center bg-primary-transparent download-now" data-bs-toggle="tooltip" data-bs-placement="top" title="Download QR Code">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"/></svg>
                </button>
                <button id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center edit bg-success-transparent editIcon"  data-bs-toggle="modal" data-bs-target="#addstudent" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <button id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent deleteIcon"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
                </td>
            </tr>';
        }

        $output .= '</tbody></table>';
        echo $output;
    } else {
        echo '<div class="alert alert-danger bg-danger text-white" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle me-2" style="width: 20px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        No record in the database!
    </div>';
    }
}


public function fetchstudent_logs() {
    
    $api = DB::table('table_logs')
        ->join('students', 'students.id', '=', 'table_logs.Student_ID') // Left join on 'team_id'
        ->select('table_logs.*', 'students.*') // Select all columns from both table
        ->orderBy('table_logs.Date', 'desc')
        ->get();


    $output = ''; // Initialize the $output variable

    if ($api->count() > 0) {
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead  class="text-dark">  
                <tr>
                    <th>ID</th>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Parent Number</th>
                    <th>Date</th>
                    <th>Morning IN</th>
                    <th>Morning OUT</th>
                    <th>Afternoon IN</th>
                    <th>Afternoon OUT</th>
                </tr>
            </thead>
            <tbody>';

            foreach ($api as $rs) {
                // Convert date to PH time zone
                $phTime = Carbon::parse($rs->Date)->setTimezone('Asia/Manila')->format('F d, Y');

                // Format time with AM/PM or display N/A if time is null
                $amIn = $rs->AM_in ? Carbon::parse($rs->AM_in)->setTimezone('Asia/Manila')->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';
                $amOut = $rs->AM_out ? Carbon::parse($rs->AM_out)->setTimezone('Asia/Manila')->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';
                $pmIn = $rs->PM_in ? Carbon::parse($rs->PM_in)->setTimezone('Asia/Manila')->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';
                $pmOut = $rs->PM_out ? Carbon::parse($rs->PM_out)->setTimezone('Asia/Manila')->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';
            
                $output .= '<tr>
                    <td>' . $rs->id . '</td>
                    <td class="align-items-center"><img style="cursor: pointer;" src="storage/images/' . $rs->Image . '" class="rounded-circle wh-50" onclick="openImageViewer(\'storage/images/' . $rs->Image . '\')"><span class="fw-medium fs-15 ms-3">' . $rs->Student_Number . '</span></td>
                    <td>' . $rs->Name . '</td>
                    <td>' . $rs->Parent_Name . '</td>
                    <td>' . $rs->Parent_Number . '</td>
                    <td>' . $phTime . '</td>
                    <td>' . $amIn . '</td>
                    <td>' . $amOut . '</td>
                    <td>' . $pmIn . '</td>
                    <td>' . $pmOut . '</td>
                </tr>';
            }
            

        $output .= '</tbody></table>';
        echo $output;
    } else {
        echo '<div class="alert alert-danger bg-danger text-white" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle me-2" style="width: 20px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        No record in the database!
    </div>';
    }
}

// Add new student or update existing student AJAX request
public function store_student(Request $request) {
    // Include image validation only if the existing image is empty
    if (empty($request->student_id)) {
        $rules = [
            'student_number' => 'required|unique:students,Student_Number',
            'fullname' => 'required',
            'parent_name' => 'required',
            'parent_number' => ['required', new PhilippinePhoneNumber],
            'grade' => 'required',
            'address' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Process the validated data
        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName); //php artisan storage:link

        $empData = [
            'Student_Number' => $validatedData['student_number'],
            'Name' => $validatedData['fullname'],
            'Parent_Name' => $validatedData['parent_name'],
            'Parent_Number' => $validatedData['parent_number'],
            'Grade' => $validatedData['grade'],
            'Address' => $validatedData['address'],
            'Image' => $fileName,
        ];
    } else {
        // Validate the request data for update
        $rules = [
            'student_number' => 'required',
            'fullname' => 'required',
            'parent_name' => 'required',
            'parent_number' => ['required', new PhilippinePhoneNumber],
            'grade' => 'required',
            'address' => 'required',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Process the validated data
        $empData = [
            'Student_Number' => $validatedData['student_number'],
            'Name' => $validatedData['fullname'],
            'Parent_Name' => $validatedData['parent_name'],
            'Parent_Number' => $validatedData['parent_number'],
            'Grade' => $validatedData['grade'],
            'Address' => $validatedData['address'],
        ];
    }

    try {
        if (!empty($request->student_id)) {
            $student = students::findOrFail($request->student_id);
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName); //php artisan storage:link
                $empData['Image'] = $fileName;
            }

            $student->update($empData);
            return response()->json(['status' => 200, 'message' => 'Student Updated Successfully']);
        } else {
            // If student_id is empty or image is empty for update, create new student
            students::create($empData);
            return response()->json(['status' => 200, 'message' => 'Student Added Successfully']);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 500, 'message' => $e->getMessage()]);
    }
}



public function scanner_morning(Request $request)
{

    // Search for the student ID based on the provided scanid
    $student = students::where('Student_Number', $request->scanid)->first();
    
    // Fetch the active API details from the sms_apis table
    $activeApi = SmsApi::where('active', 'Active')->first();


    if (!$student) {
        return response()->json([
            'status' => 400,
            'message' => 'Student ID not found',
        ]);
    }

    // Get the ID primary of the student
    $studentId = $student->id;

    // Get the current time in PH time
    $currentTime = Carbon::now('Asia/Manila')->format('H:i:s');

    // Determine whether it's AM or PM based on the current time
    $timeCategory = ($currentTime < '12:00:00') ? 'AM' : 'PM';

    // Check if there is already a record for today with the student ID
    $existingLog = table_logs::where('Student_ID', $studentId)
        ->whereDate('created_at', today())
        ->first();

// Get the current time in Manila time (PH time) with AM/PM format
$manilaTime = Carbon::now('Asia/Manila')->format('F d, Y h:i A');

$semaphoreText = "$student->Name ($student->Student_Number), arrived in the school at $manilaTime";

    $ch = curl_init();
$parameters = array(
    'apikey' => $activeApi->api,
    'number' => $student->Parent_Number,
    'message' => 'Senior Highschool : ' . $semaphoreText,
    'sendername' => 'LandogzWeb'
);



    if ($existingLog) {
        // Retrieve the value of AM_in and PM_in from $existingLog if they exist
        $AM_in = $existingLog->AM_in ?? null;
        $PM_in = $existingLog->PM_in ?? null;

        if ($timeCategory === 'AM') {
            if ($AM_in === null || empty($AM_in)) {
                $existingLog->update(['AM_in' => $currentTime]);

                $responseData = [
                    'status' => 200,
                    'message' => 'Successfully arrived to the Campus!',
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->Name,
                        'student_number' => $student->Student_Number,
                        'image_url' => $student->Image,
                        'grade' => $student->Grade,
                        // Add other details as needed
                    ],
                ];
                
curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close ($ch);

            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'You already scanned your QR Code',
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->Name,
                        'student_number' => $student->Student_Number,
                        'image_url' => $student->Image,
                        'grade' => $student->Grade,
                        // Add other details as needed
                    ],
                ]);
            }
        } else {
            if ($PM_in === null || empty($PM_in)) {
                $existingLog->update(['PM_in' => $currentTime]);

                $responseData = [
                    'status' => 200,
                    'message' => 'Successfully arrived to the Campus!',
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->Name,
                        'student_number' => $student->Student_Number,
                        'image_url' => $student->Image,
                        'grade' => $student->Grade,
                        // Add other details as needed
                    ],
                ];
                
curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close ($ch);


            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'You already scanned your QR Code',
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->Name,
                        'student_number' => $student->Student_Number,
                        'image_url' => $student->Image,
                        'grade' => $student->Grade,
                        // Add other details as needed
                    ],
                ]);
            }
        }
    } else {
               // Create a new record if no record is found
               table_logs::create([
                'Student_ID' => $studentId,
                'Date' => today(),
                $timeCategory . '_in' => $currentTime, // Set AM_in or PM_in based on the time
                'created_at' => now(),
            ]);

       

        // Prepare the response data indicating new record creation
        $responseData = [
            'status' => 200,
            'message' => 'Successfully entered to the Campus!',
            'student' => [
                'id' => $student->id,
                'name' => $student->Name,
                'student_number' => $student->Student_Number,
                'image_url' => $student->Image,
                'grade' => $student->Grade,
                // Add other details as needed
            ],
        ];
        
curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec( $ch );
curl_close ($ch);
    }

    return response()->json($responseData);
}




 
 // edit an student ajax request
 public function edit(Request $request) {
    $id = $request->id;
    $emp = students::find($id);
    return response()->json($emp);
}

    // delete student ajax request
    public function delete_student(Request $request) {
        $id = $request->id;
        $emp = students::find($id);
        if (Storage::delete('public/images/' . $emp->Image)) {
            students::destroy($id);
        }
    }


}
