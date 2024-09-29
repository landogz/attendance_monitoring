<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\LoginLog; // Add this to use the LoginLog model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // Import Http facade
use Carbon\Carbon;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard','get_profile','store_profile','store_profile_edit','delete_account'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'privilege' => $request->priv,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }

    public function store_profile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:250',
                'email' => 'required|email|max:250|unique:users,email,' . auth()->id(), // Ignore current user's email for uniqueness validation
                'password' => 'nullable|min:8|confirmed' // Update password only if provided
            ]);
        
            // Find the authenticated user
            $user = User::findOrFail(auth()->id());
        
            // Update the user's name and email
            $user->name = $request->name;
            $user->email = $request->email;
            $user->privilege = $request->priv;
            $user->Grade = $request->grade;
        
            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                Auth::logout();
            }
        
            $user->save();
        
            return response()->json(['status' => 200, 'message' => 'Profile updated successfully!']);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    public function store_profile_edit(Request $request)
    {
        try {
            // Check if the profile ID is null, indicating a new account creation
            if ($request->profile_id === null || $request->profile_id === '') {
                $request->validate([
                    'name_profile' => 'required|string|max:250',
                    'email_profile' => 'required|email|max:250|unique:users,email',
                    'password_profile' => 'required|min:8|confirmed'
                ]);
    
                // Create a new user
                $user = new User();
                $user->name = $request->name_profile;
                $user->email = $request->email_profile;
                $user->privilege = $request->priv;
                $user->Grade = $request->grade;
                $user->password = Hash::make($request->password_profile);
                $user->save();
    
                return response()->json(['status' => 200, 'message' => 'Account created successfully!']);
            } else {
                // Update an existing user profile
                $request->validate([
                    'name_profile' => 'required|string|max:250',
                    'email_profile' => 'required|email|max:250|unique:users,email,' . $request->profile_id, // Ignore current user's email for uniqueness validation
                    'password_profile' => 'nullable|min:8|confirmed' // Update password only if provided
                ]);
    
                // Find the authenticated user
                $user = User::findOrFail($request->profile_id);
    
                // Update the user's name and email
                $user->name = $request->name_profile;
                $user->email = $request->email_profile;
                $user->privilege = $request->priv;
                $user->Grade = $request->grade;
    
                // Update password if provided
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password_profile);
                }
    
                $user->save();
    
                return response()->json(['status' => 200, 'message' => 'Profile updated successfully!']);
            }
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    
        // delete student ajax request
        public function delete_account(Request $request) {
            $id = $request->id;
            $emp = User::find($id);
            
            User::destroy($id);
        }
    

public function get_profile(Request $request) {
    $id = $request->id;
    $emp = User::find($id);
    return response()->json($emp);

}


    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

       

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();

               // Fetch global IP address using ipify API
        $globalIpResponse = Http::get('https://api.ipify.org?format=json');
        $globalIp = $globalIpResponse->json('ip');

        // Get the current timestamp in Philippine Time (PHT)
        $phTime = Carbon::now('Asia/Manila'); // Specify the timezone

               // Log the login details in the login_logs table
          LoginLog::create([
            'user_id' => Auth::id(),                       // Authenticated user's ID
            'ip_address' => $globalIp,                     // Global IP address
            'user_agent' => $request->header('User-Agent'), // Browser and device info
            'login_time' => $phTime,                       // Current timestamp in PHT
        ]);


            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    } 
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::check())
        {
            return view('auth.dashboard');
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 

    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
         // Update the logged-in user (e.g., set last active time)
    if (Auth::check()) {
        $user = User::find(Auth::id()); // Find the currently authenticated user

        // Update any user attributes before logout
        $user->last_active = now();  // Update last active timestamp (example)
        $user->save();               // Save changes to the user
    }
    
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }    

}