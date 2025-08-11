<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * --------------------------------------------------------------------------
 * Employee Management API Routes
 * --------------------------------------------------------------------------
 * These routes offer CRUD operations for the HRMS modules.
 * Each route is named, follows RESTful conventions, and uses controllers.
 */

Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('signup', [App\Http\Controllers\AuthController::class, 'signup'])->name('signup');
Route::post('forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('verify-email', [App\Http\Controllers\AuthController::class, 'verifyEmail'])->name('verify-email');
Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
Route::post('verify-otp', [App\Http\Controllers\AuthController::class, 'verifyOtp'])->name('verify-otp');
Route::post('resend-otp', [App\Http\Controllers\AuthController::class, 'resendOtp'])->name('resend-otp');
Route::post('password/update', [App\Http\Controllers\AuthController::class, 'updatePassword'])->name('password.update');
Route::get('password/successful', function () {
    return view('auth.passwordsuccessful');
})->name('password.successful');


Route::middleware('auth:api')->post('updateProfile', [App\Http\Controllers\AuthController::class, 'updateProfile'])->name('profile.update');
Route::get('/password/reset/{token}', function ($token) {
    return view('welcome', ['token' => $token]);
})->name('password.reset');

Route::post('seeduser', function () {
    $user = \App\Models\User::create([
        'name' => 'Sample User 1',
        'email' => 'sampleuser1@example.com',
        'phone' => '1234567890',
        'password' => bcrypt('password123'),
    ]);
    return response()->json($user, 201);
});
Route::get('users', function () {
    return response()->json(\App\Models\User::all());
})->name('users.index');



// Employee CRUD
Route::apiResource('employees', App\Http\Controllers\EmployeeController::class);

// Leave Types
Route::apiResource('leave-types', App\Http\Controllers\LeaveTypeController::class);

// Leave Balances
Route::apiResource('leave-balances', App\Http\Controllers\LeaveBalanceController::class);

// Leave Requests
Route::apiResource('leave-requests', App\Http\Controllers\LeaveRequestController::class);

// Salary Components
Route::apiResource('salary-components', App\Http\Controllers\SalaryComponentController::class);

// Employee Salaries
Route::apiResource('employee-salaries', App\Http\Controllers\EmployeeSalaryController::class);

// Payrolls
Route::apiResource('payrolls', App\Http\Controllers\PayrollController::class);

// Payslips
Route::apiResource('payslips', App\Http\Controllers\PayslipController::class);

// Tax Statements
Route::apiResource('tax-statements', App\Http\Controllers\TaxStatementController::class);

// Documents
Route::apiResource('documents', App\Http\Controllers\DocumentController::class);

// Performance Goals
Route::apiResource('performance-goals', App\Http\Controllers\PerformanceGoalController::class);

// Performance Reviews
Route::apiResource('performance-reviews', App\Http\Controllers\PerformanceReviewController::class);

// Feedback
Route::apiResource('feedback', App\Http\Controllers\FeedbackController::class);

// Promotion Recommendations
Route::apiResource('promotion-recommendations', App\Http\Controllers\PromotionRecommendationController::class);

// Courses
Route::apiResource('courses', App\Http\Controllers\CourseController::class);

// Course Assignments
Route::apiResource('course-assignments', App\Http\Controllers\CourseAssignmentController::class);

// Certifications
Route::apiResource('certifications', App\Http\Controllers\CertificationController::class);

// Announcements
Route::apiResource('announcements', App\Http\Controllers\AnnouncementController::class);

// Analytics Logs
Route::apiResource('analytics-logs', App\Http\Controllers\AnalyticsLogController::class);

// Reports
Route::apiResource('reports', App\Http\Controllers\ReportController::class);

// Audit Trails
Route::apiResource('audit-trails', App\Http\Controllers\AuditTrailController::class);

// Attendances
Route::apiResource('attendances', App\Http\Controllers\AttendanceController::class);

// Weekly Attendance Logs
Route::apiResource('weekly-attendance-logs', App\Http\Controllers\WeeklyAttendanceLogController::class);

// Monthly Attendance Logs
Route::apiResource('monthly-attendance-logs', App\Http\Controllers\MonthlyAttendanceLogController::class);
