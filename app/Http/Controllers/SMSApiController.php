<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsApi;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Http;


class SMSApiController extends Controller
{
    public function index(){
        // $api = DB::table('table_sms_api')->get();

      return view('sms_api');
  }

  public function fetchApis() {
    
    $api = DB::table('sms_apis')->get();

    $output = ''; // Initialize the $output variable

    if ($api->count() > 0) {
        $output .= '<table id="basic_config" class="table align-middle table-bordered">
            <thead  class="text-dark">  
                <tr>
                    <th>ID</th>
                    <th>Account ID</th>
                    <th>Account Status</th>
                    <th>Credit Balance</th>
                    <th>API</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($api as $rs) {
            $output .= '<tr>
                <td>' . $rs->id . '</td>
                <td>' . $rs->account_id . '</td>
                <td>' . $rs->status . '</td>
                <td>' . $rs->credit_balance . '</td>
                <td>' . $rs->api . '</td>
                <td>' . ($rs->active === 'Inactive' ? '<span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Inactive</span>' : '<span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">Active</span>') . '</td>
                <td>
                
                <button id="' . $rs->id . '" data-active="'. $rs->active .'" name="delete" class="icon border-0 rounded-circle text-center edit bg-success-transparent active-item"  data-bs-toggle="tooltip" data-bs-placement="top" title="'. ($rs->active === 'Inactive' ? 'Set to Active' : 'Set to Inactive')  .'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </button>
                <button id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
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

 // update an header ajax request
 public function validateapi (Request $request) {
    $api = $request->api_value;
    $apiUrl = 'https://api.semaphore.co/api/v4/account';

    $fullApiUrl = $apiUrl . '?apikey=' . $api;
    $response = Http::get($fullApiUrl);

    // Check if the request was successful
    if ($response->successful()) {
        // Get the JSON response data
        $responseData = $response->json();

        // Return the JSON response with status 200 and the API data
        return response()->json([
            'status' => 200,
            'data' => $responseData,
        ]);
    } else {
        // If the request was not successful, return an error response
        return response()->json([
            'status' => 400,
            'message' => 'Failed to fetch data from the API.',
        ], 400);
    }

}

public function saveapi(Request $request)
{
    // Validate the request data
    $request->validate([
        'api' => 'required|unique:sms_apis,api',
    ]);

    // Remove double quotes from the request data
    $cleanedData = [];
    foreach ($request->all() as $key => $value) {
        $cleanedData[$key] = str_replace('"', '', $value);
    }

    // Create a new SMS API record with cleaned data
    SmsApi::create([
        'api' => $cleanedData['api'],
        'account_id' => $cleanedData['account_id'],
        'account_name' => $cleanedData['account_name'],
        'status' => $cleanedData['status'],
        'credit_balance' => $cleanedData['credit_balance'],
        'active' => 'Inactive',
    ]);

    // Return a JSON response indicating success
    return response()->json([
        'status' => 200,
        'message' => 'SMS API saved successfully',
    ]);
}


// delete an api ajax request
public function deleteapi(Request $request) {
    $id = $request->id;
    $emp = SmsApi::find($id);
        // Delete the employee
$emp->delete();
}


// Update all APIs except the specified one to 'Inactive'
public function updateapi(Request $request) {
    $id = $request->id;    
    $act = $request->active;

    if($act == 'Inactive'){

    // Set all APIs to 'Inactive' except the specified one
    SmsApi::where('id', '!=', $id)->update(['active' => 'Inactive']);

    // Set the specified API to 'Active'
    $emp = SmsApi::find($id);
    if ($emp) {
        $emp->active = 'Active';
        $emp->save();
    }
    
    }
    else{
        // Set the specified API to 'Active'
    $emp = SmsApi::find($id);
    if ($emp) {
        $emp->active = 'Inactive';
        $emp->save();
    }
    }

    
    return response()->json([
        'status' => 200,
        'message' => 'API updated successfully',
    ]);
}



}
