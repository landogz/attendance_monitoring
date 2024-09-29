<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\SMSApiController;
use App\Http\Controllers\studentsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\user;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/exit', function () {
    return view('exit');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
    Route::post('/store', [LoginRegisterController::class, 'store'])->name('store');
    Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
    
    Route::post('/scanner_morning', [studentsController::class, 'scanner_morning'])->name('scanner_morning');
    Route::post('/scanner_afternoon', [studentsController::class, 'scanner_afternoon'])->name('scanner_afternoon');
    
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
        Route::get('/get_profile', [LoginRegisterController::class, 'get_profile'])->name('get_profile');
        Route::post('/store_profile', [LoginRegisterController::class, 'store_profile'])->name('store_profile');
        Route::post('/store_profile_edit', [LoginRegisterController::class, 'store_profile_edit'])->name('store_profile_edit');
        Route::delete('/delete_account', [LoginRegisterController::class, 'delete_account'])->name('delete_account');


        Route::get('/smsapi', [SMSApiController::class, 'index'])->name('smsapi');
        Route::get('/fetchApis', [SMSApiController::class, 'fetchApis'])->name('fetchApis');
        Route::post('/validateapi', [SMSApiController::class, 'validateapi'])->name('validateapi');
        Route::post('/saveapi', [SMSApiController::class, 'saveapi'])->name('saveapi');
        Route::delete('/deleteapi', [SMSApiController::class, 'deleteapi'])->name('deleteapi');
        Route::post('/updateapi', [SMSApiController::class, 'updateapi'])->name('updateapi');

        
        Route::get('/students', [studentsController::class, 'index'])->name('students');
        Route::get('/fetchAccounts', [studentsController::class, 'fetchAccounts'])->name('fetchAccounts');
        Route::post('/store_student', [studentsController::class, 'store_student'])->name('store_student');
        Route::delete('/delete_student', [studentsController::class, 'delete_student'])->name('delete_student');
        Route::get('/edit_student', [studentsController::class, 'edit'])->name('edit_student');
        

        
        Route::get('/student-logs', [studentsController::class, 'student_logs'])->name('students-logs');
        Route::get('/fetchstudent_logs', [studentsController::class, 'fetchstudent_logs'])->name('fetchstudent_logs');
        Route::get('/student-logs/data', [studentsController::class, 'student_logs_data'])->name('student_logs_data');

        
        Route::get('/printGrade/{grade}', [studentsController::class, 'printGrade'])->name('printGrade');

        
        Route::get('/accounts', [user::class, 'index'])->name('accounts');
        Route::get('/fetchAdminAccounts', [user::class, 'fetchAdminAccounts'])->name('fetchAdminAccounts');

        Route::get('/loginlogs', [LoginLogController::class, 'loginlogs'])->name('loginlogs');
        Route::get('/fetchLoginLogs', [LoginLogController::class, 'fetchLoginLogs'])->name('fetchLoginLogs');

        
        Route::get('/subjects', [SubjectsController::class, 'index'])->name('subjects');
        Route::get('/fetchsubjects', [SubjectsController::class, 'fetchsubjects'])->name('fetchsubjects');
        Route::post('/store_subject', [SubjectsController::class, 'store_subject'])->name('store_subject');
        Route::get('/edit_subject', [SubjectsController::class, 'edit'])->name('edit_subject');
        Route::delete('/delete_subject', [SubjectsController::class, 'delete_subject'])->name('delete_subject');

        Route::get('/scan-subject/{subject}', [SubjectsController::class, 'scan'])->name('scan');
        Route::post('/scanner_subject', [SubjectsController::class, 'scanner_subject'])->name('scanner_subject');

        Route::get('/subjects_logs', [SubjectsController::class, 'subjects_logs'])->name('subjects_logs');
        // Route::get('/subjects_logs_data', [SubjectsController::class, 'subjects_logs_data'])->name('subjects_logs_data');
       
        // Route to fetch the subject logs data (AJAX call)
        Route::get('/subjects-logs/data', [SubjectsController::class, 'subjects_logs_data'])->name('subjects_logs_data');

        
    
    });
});