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

    public function subjects_logs(Request $request) {
        // Get the logged-in user
        $user = Auth::user();
        
        // Fetch all subjects for the dropdown based on user privilege
        $subjects = Subject::when($user->privilege === 'Teacher', function ($query) use ($user) {
            return $query->where('grade', $user->Grade); // Filter by the teacher's grade
        })->get();
        
        // You can add any additional logic for Administrators if needed
        if ($user->privilege === 'Administrator'  || $user->privilege === 'Principal') {
            // Fetch all subjects or apply specific logic for administrators
            $subjects = Subject::all();
        }
    
        // If a date range and subject are provided in the request, filter logs accordingly
        $logs = [];
        if ($request->has(['subject_id', 'start_date', 'end_date'])) {
            $logs = SubjectLog::where('subject_id', $request->subject_id)
                ->whereBetween('date', [$request->start_date, $request->end_date])
                ->get();
        }
    
        // Pass the subjects and logs to the view
        return view('subjects_logs', compact('subjects', 'logs'));
    }

    
    
    public function subjects_logs_data(Request $request) {
    
     // Get the logged-in user
     $user = Auth::user();

     // Check if a subject_id and date range are passed from the AJAX request
     $subjectId = $request->input('subject_id');
     $startDate = $request->input('start_date');
     $endDate = $request->input('end_date');
     $handledGrade = $user->Grade;

     // Build the query based on the user privilege
     if ($user->privilege === 'Administrator'  || $user->privilege === 'Principal') {
        //  $api = DB::table('subject_logs')
        //      ->join('students', 'students.id', '=', 'subject_logs.Student_ID')
        //      ->join('subject', 'subject_logs.subject_id', '=', 'subject.id')
        //      ->select('subject_logs.*', 'students.*', 'subject.subject_name', 'subject.start_time', 'subject_logs.id as student_log_id'); // Include student_logs.id
        $api = DB::table('students')
        ->select(
            'students.*',
            'subject.*',
            DB::raw('COALESCE(subject_logs.Date, all_dates.Date) AS log_date'),
            'subject.Subject_Name AS subject_name',
            'subject_logs.*'
        )
        ->distinct('students.Student_Number')
        ->crossJoin(DB::raw('(SELECT DISTINCT Date FROM subject_logs) AS all_dates'))
        ->crossJoin('subject')
        ->leftJoin('subject_logs', function ($join) {
            $join->on('students.id', '=', 'subject_logs.Student_ID')
                 ->on('all_dates.Date', '=', 'subject_logs.Date')
                 ->on('subject.id', '=', 'subject_logs.subject_id');
        })
        ->orderBy('students.Student_Number', 'asc')
        ->orderBy('log_date', 'desc')
        ->orderBy('subject.id', 'asc');
    
 
         // If a subject is selected, filter by subject ID
         if ($subjectId) {
            $api->where('subject.id', $subjectId);
         }
 
         // If a date range is provided, filter by the date range
         if ($startDate && $endDate) {
            $api->whereBetween(DB::raw('COALESCE(subject_logs.Date, all_dates.Date)'), [$startDate, $endDate]);
         }
 
         $api = $api->get();
     } else if ($user->privilege === 'Teacher') {
        //  $api = DB::table('subject_logs')
        //      ->join('students', 'students.id', '=', 'subject_logs.Student_ID')
        //      ->join('subject', 'subject_logs.subject_id', '=', 'subject.id')
        //      ->where('students.Grade', $handledGrade )
        //      ->select('subject_logs.*', 'students.*', 'subject.subject_name', 'subject.start_time', 'subject_logs.id as student_log_id'); // Include student_logs.id
       
        $api = DB::table('students')
        ->select(
            'students.*',
            'subject.*',
            DB::raw('COALESCE(subject_logs.Date, all_dates.Date) AS log_date'),
            'subject.Subject_Name AS subject_name',
            'subject_logs.*'
        )
        ->distinct('students.Student_Number')
        ->crossJoin(DB::raw('(SELECT DISTINCT Date FROM subject_logs) AS all_dates'))
        ->crossJoin('subject')
        ->leftJoin('subject_logs', function ($join) {
            $join->on('students.id', '=', 'subject_logs.Student_ID')
                 ->on('all_dates.Date', '=', 'subject_logs.Date')
                 ->on('subject.id', '=', 'subject_logs.subject_id');
        })
        ->where('students.Grade', $handledGrade )
        ->where('subject.user_id', $user->id )
        ->orderBy('students.Student_Number', 'asc')
        ->orderBy('log_date', 'desc')
        ->orderBy('subject.id', 'asc');

         // If a subject is selected, filter by subject ID
         if ($subjectId) {
             $api->where('subject.id', $subjectId);
         }
 
         // If a date range is provided, filter by the date range
         if ($startDate && $endDate) {
            $api->whereBetween(DB::raw('COALESCE(subject_logs.Date, all_dates.Date)'), [$startDate, $endDate]);
         }
 
         $api = $api->get();
     }
    
        // Prepare the output HTML
    $logsCount = $api->count(); // Get the count of logs
    $naCount = 0; // Initialize counter for N/A entries

    // Check log count and set the output accordingly
    $output = '';
    $badgeHtml = '';

    if ($logsCount > 0) {
        // Set badge for success
        $badgeHtml = '<h3>Total Count : <span class="badge bg-success">' . $logsCount . '</span></h3>';

        $output .= '<form id="deleteLogsForm">'; // Add a form tag
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead class="text-dark">  
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
                    <th>OUT</th>
                    <th>LATE</th> <!-- New LATE column -->
                </tr>
            </thead>
            <tbody>';

        foreach ($api as $rs) {
            // Convert date to PH time zone
            $phTime = Carbon::parse($rs->log_date)->format('F d, Y');

       // Count N/A entries
       if (is_null($rs->In)) {
        $naCount++; // Increment N/A count if In or Out is null
    }

            // Format time with AM/PM or display N/A if time is null
            $amIn = $rs->In ? Carbon::parse($rs->In)->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';
            $amOut = $rs->Out ? Carbon::parse($rs->Out)->format('h:i A') : '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>';
   
     
             // Format Out time
            if (is_null($rs->In)) {
                $outTime = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">N/A</span>'; // If In is null, set Out to N/A
            } elseif (is_null($rs->Out)) {
                $amOut = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-warning">Cutting</span>'; // If Out is null but In is not
            } else {
                $amOut = Carbon::parse($rs->Out)->format('h:i A'); // Format Out if not null
            }
            
            // Determine if the student is late
            $lateStatus = '';
            if ($rs->In) {
                $inTime = Carbon::parse($rs->In);
                $startTime = Carbon::parse($rs->start_time);
                
                // Check if late by 15 minutes
                if ($inTime->gt($startTime->addMinutes(15))) {
                    $lateStatus = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-danger">Yes</span>'; // Student is late
                } else {
                    $lateStatus = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-success">No</span>'; // Student is on time
                }
            } else {
                $lateStatus = '<span class="badge rounded-pill fs-13 fw-normal py-2 px-3 bg-warning">N/A</span>'; // No IN time available
            }


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
                <td>' . $amOut . '</td>
                <td>' . $lateStatus . '</td> <!-- LATE status -->
            </tr>';
        }

        $output .= '</tbody></table>';
        $output .= '</form>'; // Close the form
    } else {
        // Set badge for danger
        $badgeHtml = '<h3>Total Count :  <span class="badge bg-danger">0</span></h3>';

        $output .= '<div class="alert alert-danger bg-danger text-white" role="alert">No record in the database!</div>';
    }

    // Return both the output and the logs count as JSON, along with the badge HTML
    return response()->json(['html' => $output, 'log_count' => $logsCount, 'na_count' => $naCount, 'badge' => $badgeHtml]);
    }
    
public function fetchsubjects() {
    
    
    // Get the logged-in user
    $user = Auth::user();

    // Get the handled grade for the logged-in user
    $handledGrade = $user->Grade;

    // Get subjects for the logged-in user based on the handled grade and user ID


        if ($user->privilege === 'Administrator'  || $user->privilege === 'Principal') {
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

    // Check if there's already a record for today
    $record = SubjectLog::where('student_id', $studentId)
        ->where('subject_id', $request->subject_id)
        ->whereDate('Date', today())
        ->first();

    if ($request->time_action === 'time_in') {
        if ($record) {
            return response()->json([
                'status' => 400,
                'message' => 'Student already recorded for Time In today.',
            ]);
        }

        // Create a new record for Time In
        SubjectLog::create([
            'student_id' => $studentId,
            'subject_id' => $request->subject_id,
            'Date' => today(),
            'In' => $currentTime,
            'created_at' => now(),
        ]);

        $responseData = [
            'status' => 200,
            'message' => 'Successfully entered to the ' . $subject->Subject_Name . ' subject!',
            'student' => [
                'id' => $student->id,
                'name' => $student->Name,
                'student_number' => $student->Student_Number, 
                'image_url' => $student->Image,
                'grade' => $student->Grade,
            ],
        ];

        // Custom message for Time In
        $semaphoreText = "Ang inyong anak na si $student->Name ($student->Student_Number) ay pumasok sa subject na $subject->Subject_Name ";
    } elseif ($request->time_action === 'time_out') {
        // If no record exists for Time In
        if (!$record) {
            return response()->json([
                'status' => 400,
                'message' => 'No Time In record found for today. Please scan Time In first.',
            ]);
        }

        // Update the existing record for Time Out
        $record->Out = $currentTime; // Update the "Out" field
        $record->save();

        $responseData = [
            'status' => 200,
            'message' => 'Successfully recorded Time Out for ' . $subject->Subject_Name . ' subject!',
            'student' => [
                'id' => $student->id,
                'name' => $student->Name,
                'student_number' => $student->Student_Number, 
                'image_url' => $student->Image,
                'grade' => $student->Grade,
            ],
        ];

        // Custom message for Time Out
        $semaphoreText = "Ang inyong anak na si $student->Name ($student->Student_Number) ay nakalabas na sa subject na $subject->Subject_Name ";
    }

    // Send SMS notification
    $ch = curl_init();
    $parameters = array(
        'apikey' => $activeApi->api,
        'number' => $student->Parent_Number,
        'message' => 'Junior Highschool : ' . $semaphoreText,
        'sendername' => 'PRMSU'
    );

    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    return response()->json($responseData);
}


public function delete_selected_logs(Request $request)
{
    $ids = $request->input('ids');

    if (empty($ids)) {
        return response()->json(['status' => 400, 'message' => 'No logs selected.']);
    }

    // Delete logs with the selected IDs
    SubjectLog::whereIn('id', $ids)->delete();

    return response()->json(['status' => 200, 'message' => 'Selected logs deleted successfully.']);
}

public function delete_logs()
{
    // Get the logged-in user (teacher)
    $user = Auth::user();

    // Fetch all subject IDs assigned to this user (teacher)
    $subjectIds = Subject::where('user_id', $user->id)->pluck('id')->toArray();

    // If no subjects are found, return a response indicating no logs to delete
    if (empty($subjectIds)) {
        return response()->json(['success' => false, 'message' => 'No subjects found for the logged-in teacher.']);
    }

    // Delete all logs in subject_logs table where the subject_id is in the fetched subject IDs
    $deletedLogs = SubjectLog::whereIn('subject_id', $subjectIds)->delete();

    // If no logs were deleted, return a message indicating nothing was deleted
    if ($deletedLogs == 0) {
        return response()->json(['success' => false, 'message' => 'No subject logs found to delete.']);
    }

    // Return success response
    return response()->json(['success' => true, 'message' => 'Subject logs deleted successfully.']);
}



}
