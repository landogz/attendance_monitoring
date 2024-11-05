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
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Maatwebsite\Excel\Facades\Excel;

class studentsController extends Controller
{
    public function index(){
      return view('students');
  }

  public function student_logs(){
    return view('student_logs');
}

public function importStudents(Request $request)
{

    try {
    // Validate that the uploaded file is required and is an Excel file
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    // Load the Excel file
    $file = $request->file('file');
    $importData = Excel::toArray([], $file);

// Check if the data exists and is in the expected format
if (isset($importData[0])) {
    // Skip the header row (index 0) and start from index 1
    foreach (array_slice($importData[0], 1) as $row) {
        // Map data using indices based on the format
        $studentNumber = $row[0];
        $fullname = $row[1];
        $email = $row[2];
        $parentName = $row[3];
        $parentNumber = $row[4];
        $grade = $row[5];
        $address = $row[6];

        // Check if the student number already exists in the database
        if (!students::where('Student_Number', $studentNumber)->exists()) {
            // Add the student if the student_number doesn't exist
            students::create([
                'Student_Number' => $studentNumber,
                'Name' => $fullname, 
                'Email' =>$email ,
                'Parent_Name' => $parentName,
                'Parent_Number' => $parentNumber,
                'Grade' => $grade,
                'Address' => $address,
            ]);
        }
    }
}

return response()->json(['status' => 'success', 'message' => 'Students imported successfully!']);

} catch (\Exception $e) {
    return response()->json(['status' => 'error', 'message' => 'Import failed: ' . $e->getMessage()], 500);
}
}


public function printGrade($grade)
{
    // Check if the grade parameter is 'all'
    if ($grade === 'all') {
        // Fetch all students and order them by Grade
        $students = DB::table('students')->orderBy('Grade', 'asc')->get();
    } else {
        // Fetch students based on the grade
        $students = DB::table('students')->where('Grade', $grade)->get();
    }

    // Check if students were fetched
    if ($students->isEmpty()) {
        return "No students found for grade " . $grade; // Or handle this more gracefully
    }

    // Return a view specifically designed for printing
    return view('print', compact('students', 'grade'));
}

public function fetchAccounts() {
    
     // Get the logged-in user
     $user = Auth::user();

     // Check if the user is an Administrator or a Teacher
     if ($user->privilege === 'Administrator' || $user->privilege === 'Principal') {
         // Administrator: Get all students
         $api = DB::table('students')->get();
     } else if ($user->privilege === 'Teacher') {
         // Teacher: Only get the students that match the grade they handle
         // Assuming the teacher is assigned a specific grade to handle (e.g., based on user details or session)
         // Let's assume that a "Teacher" is only assigned one grade
         $handledGrade = $user->Grade; // This should be fetched from the teacher's profile or wherever it is defined
         $api = DB::table('students')->where('Grade', $handledGrade)->get();
     }

    $output = ''; // Initialize the $output variable

    if ($api->count() > 0) {
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead  class="text-dark">  
                <tr>
                    <th>ID</th>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Email</th>
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
                <td>' . $rs->Email . '</td>
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
                <button style="display:none;" id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent deleteIcon"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
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

public function student_logs_data(Request $request) {
    
// Get the logged-in user
$user = Auth::user();

// Get the start and end dates from the request
$startDate1 = $request->input('start_date') ?? null;
$endDate1 = $request->input('end_date') ?? null;

// Base query to get all students and the distinct dates from table_logs
$baseQuery = DB::table('students')
    ->crossJoin(DB::raw('(SELECT DISTINCT Date FROM table_logs) AS all_dates'))
    ->leftJoin('table_logs', function ($join) {
        $join->on('students.id', '=', 'table_logs.Student_ID')
             ->on('all_dates.Date', '=', 'table_logs.Date');
    })
    ->select('students.*', DB::raw('COALESCE(table_logs.Date, all_dates.Date) AS log_date'), 'table_logs.*')
    ->orderBy('students.id', 'asc') // Order by student ID in ascending order
    ->orderBy('log_date', 'asc'); // Order by log_date in ascending order

// If user is Administrator, get all logs
if ($user->privilege === 'Administrator' || $user->privilege === 'Principal') {
    // Apply date range filter based on log_date
    if ($startDate1 && $endDate1) {
        $baseQuery->whereBetween(DB::raw('COALESCE(table_logs.Date, all_dates.Date)'), [$startDate1, $endDate1]);
    }

     // If a grade is provided, filter by the grade
     if ($request->input('start_grade')) {
        $baseQuery->where('students.Grade', $request->input('start_grade'));
    }

    
    $api = $baseQuery->get();
} else if ($user->privilege === 'Teacher') {
    // Teacher: Only get logs for students that match the grade they handle
    $handledGrade = $user->Grade; // Assuming 'Grade' is the attribute for the teacher's grade
    
    // Apply the grade filter
    $baseQuery->where('students.Grade', $handledGrade);

    // Apply date range filter based on log_date
    if ($startDate1 && $endDate1) {
        $baseQuery->whereBetween(DB::raw('COALESCE(table_logs.Date, all_dates.Date)'), [$startDate1, $endDate1]);
    }

    if ($request->input('start_grade')) {
        $baseQuery->where('students.Grade', $request->input('start_grade'));
    }

    $api = $baseQuery->get();
}



      $output = ''; // Initialize the $output variable
   
    
      if ($api->count() > 0) {
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead  class="text-dark">  
                <tr>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Grade</th>
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
                $phTime = Carbon::parse($rs->log_date)->format('F d, Y');
    
                // Format AM_IN
                if (is_null($rs->AM_in)) {
                    $amIn = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If AM_IN is null
                } else {
                    $amIn = Carbon::parse($rs->AM_in)->format('h:i A'); // Format AM_IN if not null
                }
    
                // Format AM_OUT
                if (is_null($rs->AM_in)) {
                    $amOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If AM_IN is null, AM_OUT is also N/A
                } elseif (is_null($rs->AM_out)) {
                    $amOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-warning">Cutting</span>'; // If AM_OUT is null but AM_IN is not
                } else {
                    $amOut = Carbon::parse($rs->AM_out)->format('h:i A'); // Format AM_OUT if not null
                }
    
                // Format PM_IN
                if (is_null($rs->PM_in)) {
                    $pmIn = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If PM_IN is null
                } else {
                    $pmIn = Carbon::parse($rs->PM_in)->format('h:i A'); // Format PM_IN if not null
                }
    
                // Format PM_OUT
                if (is_null($rs->PM_in)) {
                    $pmOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If PM_IN is null, PM_OUT is also N/A
                } elseif (is_null($rs->PM_out)) {
                    $pmOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-warning">Cutting</span>'; // If PM_OUT is null but PM_IN is not
                } else {
                    $pmOut = Carbon::parse($rs->PM_out)->format('h:i A'); // Format PM_OUT if not null
                }
    
                $output .= '<tr>
                    <td class="align-items-center"><img style="cursor: pointer;" src="storage/images/' . $rs->Image . '" class="rounded-circle wh-50" onclick="openImageViewer(\'storage/images/' . $rs->Image . '\')"><span class="fw-medium fs-15 ms-3">' . $rs->Student_Number . '</span></td>
                    <td>' . $rs->Name . '</td>
                    <td>' . $rs->Email . '</td>
                    <td>' . 'Grade ' . $rs->Grade . '</td>
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

public function fetchstudent_logs() {
    
// Get the logged-in user
$user = Auth::user();

// Base query to get all students and the distinct dates from table_logs
$baseQuery = DB::table('students')
    ->crossJoin(DB::raw('(SELECT DISTINCT Date FROM table_logs) AS all_dates'))
    ->leftJoin('table_logs', function ($join) {
        $join->on('students.id', '=', 'table_logs.Student_ID')
             ->on('all_dates.Date', '=', 'table_logs.Date');
    })
    ->select('students.*', DB::raw('COALESCE(table_logs.Date, all_dates.Date) AS log_date'), 'table_logs.*')
    ->orderBy('students.id', 'asc') // Order by student ID in ascending order
    ->orderBy('log_date', 'asc'); // Order by log_date in ascending order

// If user is Administrator, get all logs
if ($user->privilege === 'Administrator'  || $user->privilege === 'Principal') {
    // Apply date range filter based on log_date
    
    $api = $baseQuery->get();
} else if ($user->privilege === 'Teacher') {
    // Teacher: Only get logs for students that match the grade they handle
    $handledGrade = $user->Grade; // Assuming 'Grade' is the attribute for the teacher's grade
    
    // Apply the grade filter
    $baseQuery->where('students.Grade', $handledGrade);

    $api = $baseQuery->get();
}
        

    $output = ''; // Initialize the $output variable

    if ($api->count() > 0) {
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead  class="text-dark">  
                <tr>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Grade</th>
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
                $phTime = Carbon::parse($rs->log_date)->format('F d, Y');
    
                // Format AM_IN
                if (is_null($rs->AM_in)) {
                    $amIn = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If AM_IN is null
                } else {
                    $amIn = Carbon::parse($rs->AM_in)->format('h:i A'); // Format AM_IN if not null
                }
    
                // Format AM_OUT
                if (is_null($rs->AM_in)) {
                    $amOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If AM_IN is null, AM_OUT is also N/A
                } elseif (is_null($rs->AM_out)) {
                    $amOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-warning">Cutting</span>'; // If AM_OUT is null but AM_IN is not
                } else {
                    $amOut = Carbon::parse($rs->AM_out)->format('h:i A'); // Format AM_OUT if not null
                }
    
                // Format PM_IN
                if (is_null($rs->PM_in)) {
                    $pmIn = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If PM_IN is null
                } else {
                    $pmIn = Carbon::parse($rs->PM_in)->format('h:i A'); // Format PM_IN if not null
                }
    
                // Format PM_OUT
                if (is_null($rs->PM_in)) {
                    $pmOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If PM_IN is null, PM_OUT is also N/A
                } elseif (is_null($rs->PM_out)) {
                    $pmOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-warning">Cutting</span>'; // If PM_OUT is null but PM_IN is not
                } else {
                    $pmOut = Carbon::parse($rs->PM_out)->format('h:i A'); // Format PM_OUT if not null
                }
    
                $output .= '<tr>
                    <td class="align-items-center"><img style="cursor: pointer;" src="storage/images/' . $rs->Image . '" class="rounded-circle wh-50" onclick="openImageViewer(\'storage/images/' . $rs->Image . '\')"><span class="fw-medium fs-15 ms-3">' . $rs->Student_Number . '</span></td>
                    <td>' . $rs->Name . '</td>
                    <td>' . $rs->Email . '</td>
                    <td>' . 'Grade ' . $rs->Grade . '</td>
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
            'student_number' => ['required', 'unique:students,Student_Number', 'regex:/^\d{2}-\d-\d{4}$/'],
            'fullname' => 'required',
            'email_' => 'required',
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
            'Email' => $validatedData['email_'],
            'Parent_Name' => $validatedData['parent_name'],
            'Parent_Number' => $validatedData['parent_number'],
            'Grade' => $validatedData['grade'],
            'Address' => $validatedData['address'],
            'Image' => $fileName,
        ];
    } else {
        // Validate the request data for update
        $rules = [
            'student_number' => ['required', 'regex:/^\d{2}-\d-\d{4}$/'],
            'fullname' => 'required',
            'email_' => 'required',
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
            'Email' => $validatedData['email_'],
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

$semaphoreText = "Ang inyong anak na si $student->Name ($student->Student_Number) ay nakapasok na sa paaralan ng PRMSU Junior Highschool Iba Campus sa oras na $manilaTime";

    $ch = curl_init();
$parameters = array(
    'apikey' => $activeApi->api,
    'number' => $student->Parent_Number,
    'message' => 'Junior Highschool : ' . $semaphoreText,
    'sendername' => 'PRMSU'
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



public function scanner_afternoon(Request $request)
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

$semaphoreText = "Ang inyong anak na si $student->Name ($student->Student_Number) ay nakalabas na sa paaralan ng PRMSU Junior Highschool Iba Campus sa oras na $manilaTime";

    $ch = curl_init();
$parameters = array(
    'apikey' => $activeApi->api,
    'number' => $student->Parent_Number,
    'message' => 'Junior Highschool : ' . $semaphoreText,
    'sendername' => 'PRMSU'
);



    if ($existingLog) {
        // Retrieve the value of AM_in and PM_in from $existingLog if they exist
        $AM_in = $existingLog->AM_out ?? null;
        $PM_in = $existingLog->PM_out ?? null;

        if ($timeCategory === 'AM') {
            if ($AM_in === null || empty($AM_in)) {
                $existingLog->update(['AM_out' => $currentTime]);

                $responseData = [
                    'status' => 200,
                    'message' => 'Successfully departed to the Campus!',
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
                $existingLog->update(['PM_out' => $currentTime]);

                $responseData = [
                    'status' => 200,
                    'message' => 'Successfully departed to the Campus!',
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
                $timeCategory . '_out' => $currentTime, // Set AM_in or PM_in based on the time
                'created_at' => now(),
            ]);

       

        // Prepare the response data indicating new record creation
        $responseData = [
            'status' => 200,
            'message' => 'Successfully departed to the Campus!',
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
