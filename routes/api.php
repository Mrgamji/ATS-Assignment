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
