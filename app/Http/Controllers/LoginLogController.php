<?php

namespace App\Http\Controllers;

use App\Models\LoginLog; // Assuming you have a LoginLog model
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoginLogController extends Controller
{
    public function loginlogs()
    {
         return view('LoginLog');
    }


    public function fetchLoginLogs() {
    
        $logs = DB::table('login_logs')
        ->leftJoin('users', 'users.id', '=', 'login_logs.user_id') // Join with users table
        ->select('login_logs.*', 'users.*') // Select necessary columns, use 'users.name' instead of 'users.*'
        ->orderBy('login_logs.login_time', 'desc')
        ->get();
    
    
        $output = ''; // Initialize the $output variable
    
        if ($logs->count() > 0) {
            $output .= '<table id="basic_config" class="table align-middle table-bordered">
                <thead  class="text-dark">  
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Login Time</th>
                    </tr>
                </thead>
                <tbody>';
    
                foreach ($logs as $log) {
                    // Format dates with timezone
                    $loginTime = Carbon::parse($log->login_time)->format('F d, Y h:i A');
    
                    $output .= '<tr>
                    <td>' . $log->id . '</td>
                    <td>' . htmlspecialchars($log->name) . '</td>
                    <td>' . htmlspecialchars($log->email) . '</td>
                    <td>' . htmlspecialchars($log->ip_address) . '</td>
                    <td>' . htmlspecialchars($log->user_agent) . '</td>
                    <td>' . $loginTime . '</td>
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
}
