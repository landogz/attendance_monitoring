<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class user extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return view('accounts');
    }

    public function fetchAdminAccounts() {
        // Get the logged-in user ID
        $loggedInUserId = auth()->user()->id;
    
        $api = DB::table('users')->get();
    
        $output = ''; // Initialize the $output variable
    
        if ($api->count() > 0) {
            $output .= '<table id="basic_config" class="table align-middle table-bordered">
                <thead class="text-dark">  
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
            foreach ($api as $rs) {
                $created_at_ph = \Carbon\Carbon::parse($rs->created_at)->setTimezone('Asia/Manila')->format('F j, Y g:i a');
                $updated_at_ph = \Carbon\Carbon::parse($rs->updated_at)->setTimezone('Asia/Manila')->format('F j, Y g:i a');
    
                // Check if the logged-in user ID matches the current user ID in the loop
                $disableButton = ($loggedInUserId == $rs->id) ? 'disabled' : '';
    
                $output .= '<tr>
                    <td>' . $rs->id . '</td>
                    <td>' . $rs->name . '</td>
                    <td>' . $rs->email . '</td>
                    <td>' . $created_at_ph . '</td>
                    <td>' . $updated_at_ph . '</td>
                    <td>
                        <button id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center edit bg-success-transparent editprofile" data-bs-toggle="modal" data-bs-target="#addstudent" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" ' . $disableButton . '>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <button id="' . $rs->id . '" name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent deleteprofile" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" ' . $disableButton . '>
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
}
