<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\SmsApi;
use App\Models\students;
use App\Models\SubjectLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Rules\PhilippinePhoneNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Auth; // Import Auth facade
use DateTime;

class SubjectsController extends Controller
{
    public function index(){
        return view('subjects');
    }

    public function scan($subject)
    {
        
        // Example logic: You can now use $subject in your logic
        if ($subject) {
            // Do something with $subject, e.g., fetch data based on it
             $subjectData = Subject::find($subject);
        }
        
        // Return a view or other response
        return view('scan-subject', compact('subjectData')); // Pass $subject to the view if needed
    }
    public function subjects_logs(){
          // Fetch all subjects for the dropdown
          $subjects = Subject::all(); // You may want to filter based on user's grade
        
          // Pass the subjects to the view
          return view('subjects_logs', compact('subjects'));
    }
    
    public function subjects_logs_data(Request $request) {
    
     // Get the logged-in user
     $user = Auth::user();

     // Check if a subject_id and date range are passed from the AJAX request
     $subjectId = $request->input('subject_id');
     $startDate = $request->input('start_date');
     $endDate = $request->input('end_date');
 
     // Build the query based on the user privilege
     if ($user->privilege === 'Administrator') {
         $api = DB::table('subject_logs')
             ->join('students', 'students.id', '=', 'subject_logs.Student_ID')
             ->join('subject', 'subject_logs.subject_id', '=', 'subject.id')
             ->select('subject_logs.*', 'students.*', 'subject.subject_name');
 
         // If a subject is selected, filter by subject ID
         if ($subjectId) {
             $api->where('subject_logs.subject_id', $subjectId);
         }
 
         // If a date range is provided, filter by the date range
         if ($startDate && $endDate) {
             $api->whereBetween('subject_logs.Date', [$startDate, $endDate]);
         }
 
         $api = $api->get();
     } else if ($user->privilege === 'Teacher') {
         $api = DB::table('subject_logs')
             ->join('students', 'students.id', '=', 'subject_logs.Student_ID')
             ->join('subject', 'subject_logs.subject_id', '=', 'subject.id')
             ->select('subject_logs.*', 'students.*', 'subject.subject_name');
 
         // If a subject is selected, filter by subject ID
         if ($subjectId) {
             $api->where('subject_logs.subject_id', $subjectId);
         }
 
         // If a date range is provided, filter by the date range
         if ($startDate && $endDate) {
             $api->whereBetween('subject_logs.Date', [$startDate, $endDate]);
         }
 
         $api = $api->get();
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
                <th>Subject</th>
                <th>Date</th>
                <th>IN</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($api as $rs) {
        // Convert date to PH time zone
            $phTime = Carbon::parse($rs->Date)->format('F d, Y');

            // Format time with AM/PM or display N/A if time is null
            $amIn = $rs->In ? Carbon::parse($rs->In)->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';

            $output .= '<tr>
                <td class="align-items-center"><img style="cursor: pointer;" src="storage/images/' . $rs->Image . '" class="rounded-circle wh-50" onclick="openImageViewer(\'storage/images/' . $rs->Image . '\')"><span class="fw-medium fs-15 ms-3">' . $rs->Student_Number . '</span></td>
                <td>' . $rs->Name . '</td>
                <td>' . $rs->Email . '</td>
                 <td>' . 'Grade ' . $rs->Grade . '</td>
                <td>' . $rs->Parent_Name . '</td>
                <td>' . $rs->Parent_Number . '</td>
                <td>' . $rs->subject_name . '</td>
                <td>' . $phTime . '</td>
                <td>' . $amIn . '</td>
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
    
public function fetchsubjects() {
    
    
    // Get the logged-in user
    $user = Auth::user();

    // Get the handled grade for the logged-in user
    $handledGrade = $user->Grade;

    // Get subjects for the logged-in user based on the handled grade and user ID


        if ($user->privilege === 'Administrator') {
            $api = DB::table('subject')
            ->get();
        } else if ($user->privilege === 'Teacher') {
            $api = DB::table('subject')
            ->where('Grade', $handledGrade)
            ->where('user_id', $user->id)  // Add condition for user ID
            ->get();
        }

   $output = ''; // Initialize the $output variable

   if ($api->count() > 0) {
       $output .= '<table id="basic_config" class="table align-middle table-bordered">
           <thead  class="text-dark">  
               <tr>
                   <th>ID</th>
                   <th>Subject Name</th>
                   <th>Schedule</th>
                   <th>Grade</th>
                   <th>Actions</th>
               </tr>
           </thead>
           <tbody>';

       foreach ($api as $rs) {
           // Create DateTime objects from the extracted times
        $startTime = \DateTime::createFromFormat('H:i:s', $rs->start_time);
        $endTime = \DateTime::createFromFormat('H:i:s', $rs->end_time);
 // Format to 12-hour format with AM/PM if conversion was successful
 $formattedStartTime = $startTime ? $startTime->format('g:i A') : 'N/A';
 $formattedEndTime = $endTime ? $endTime->format('g:i A') : 'N/A';
           $output .= '<tr>
               <td>' . $rs->id . '</td>
               <td>' . $rs->Subject_Name . '</td>
               <td>' . $formattedStartTime . ' - ' . $formattedEndTime .  '</td>
               <td>' . $rs->Grade . '</td>
               <td>
              <button id="' . $rs->id . '" name="openlink" class="icon border-0 rounded-circle text-center bg-danger-transparent openlink" data-bs-toggle="tooltip" data-bs-placement="top" title="Scan"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-scanner"><rect x="3" y="8" width="18" height="12" rx="2" ry="2"></rect><path d="M3 6h18"></path><path d="M8 12h8"></path><path d="M12 16v-4"></path></svg></button>

               <button id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center edit bg-success-transparent editIcon"  data-bs-toggle="modal" data-bs-target="#addsubjectModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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




// Add new student or update existing student AJAX request
public function store_subject(Request $request) {
    $user = Auth::user();
    // Include image validation only if the existing image is empty
    if (empty($request->subject_id)) {
        $rules = [
            'subject_name' => 'required|unique:subject,Subject_Name',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        $empData = [
            'Subject_Name' => $validatedData['subject_name'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'Grade' => $user->Grade, // Get Grade from logged-in user
            'user_id' => $user->id,  // Get user_id from logged-in user
        ];
    } else {
        $rules = [
            'subject_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Process the validated data
        $empData = [
            'Subject_Name' => $validatedData['subject_name'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'Grade' => $user->Grade, // Get Grade from logged-in user
            'user_id' => $user->id,  // Get user_id from logged-in user
        ];
    }

    try {
        if (!empty($request->subject_id)) {
            $subject = Subject::findOrFail($request->subject_id);
            $subject->update($empData);
            return response()->json(['status' => 200, 'message' => 'Subject Updated Successfully']);
        } else {
            // If student_id is empty or image is empty for update, create new student
            Subject::create($empData);
            return response()->json(['status' => 200, 'message' => 'Subject Added Successfully']);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 500, 'message' => $e->getMessage()]);
    }
}

 
 // edit an student ajax request
 public function edit(Request $request) {
    $id = $request->id;
    $emp = Subject::find($id);
    return response()->json($emp);
}
   // delete student ajax request
   public function delete_subject(Request $request) {
    $id = $request->id;
    $emp = Subject::find($id);
    
    Subject::destroy($id);
}





public function scanner_subject(Request $request)
{

    // Search for the student ID based on the provided scanid
    $student = students::where('Student_Number', $request->scanid)->first();
    $subject = subject::where('id', $request->subject_id)->first();
    
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


// Get the current time in Manila time (PH time) with AM/PM format
$manilaTime = Carbon::now('Asia/Manila')->format('F d, Y h:i A');

$semaphoreText = "Ang inyong anak na si $student->Name ($student->Student_Number) ay pumasok sa subject na $subject->Subject_Name ";

$ch = curl_init();
$parameters = array(
    'apikey' => $activeApi->api,
    'number' => $student->Parent_Number,
    'message' => 'Senior Highschool : ' . $semaphoreText,
    'sendername' => 'LandogzWeb'
);


    // Create a new record if no record is found
    SubjectLog::create([
        'student_id' => $studentId,
        'subject_id' => $request->subject_id,
        'Date' => today(),
        'In' => $currentTime, // Set AM_in or PM_in based on the time
        'created_at' => now(),
    ]);



// Prepare the response data indicating new record creation
$responseData = [
    'status' => 200,
    'message' => 'Successfully entered to the ' . $subject->Subject_Name . ' subject !',
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

    return response()->json($responseData);
}


}
