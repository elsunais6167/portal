<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\Fee_setupController;
use App\Http\Controllers\Auth\TransactionController;
use App\Http\Controllers\Auth\TransactionHistoryController;
use App\Http\Controllers\Auth\NetIncomeController;
use App\Http\Controllers\Auth\ExpensesController;
use App\Http\Controllers\Auth\DeletedTransactionController;
use App\Http\Controllers\Auth\InvoiceController;
use App\Http\Controllers\Auth\InventoryController;

use App\Http\Controllers\Auth2\IndexController;
use App\Http\Controllers\Auth2\ResultController;
use App\Http\Controllers\Auth2\SettingsController;
use App\Http\Controllers\Auth2\StaffController;
use App\Http\Controllers\Auth2\StudentsController;
use App\Http\Controllers\ReceiptController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your     application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
                                                  
    Route::middleware('guest')->group( function(){
        Route::name('home_page')->get('/', [LoginController::class, 'home_page'] );
        Route::name('login')->get('staff-login', [LoginController::class, 'login_page']);
        Route::name('register')->get('register', [LoginController::class,'register_page']);
        Route::name('login_user')->post('login_user', [LoginController::class,'login_user']);
        Route::name('register_user')->post('register_user', [LoginController::class,'register_user']);
    });

Route::get('logout', function(){
    Auth::logout();
    return redirect()->route('home_page');
})->name('logout');

    Route::prefix('auth')->middleware('auth')->group( function(){
        Route::name('dashboard')->get('dashboard', [DashboardController::class,'index']);
        /***
         * FEE SETUP ROUTES
         */
        Route::name('get_fee_type_item_options')->get('get_fee_type_item_options', [Fee_setupController::class,'get_fee_type_item_options']);
        Route::name('fee_setup')->get('/fee_setup', [Fee_setupController::class,'index']);
        Route::name('store_fee_type')->post('/store_fee_type', [Fee_setupController::class,'store_fee_type']);
        Route::name('fetch_fee_types')->get('/fetch_fee_types', [Fee_setupController::class,'fetch_fee_types']);
        Route::name('store_fee_allocation')->post('/store_fee_allocation', [Fee_setupController::class,'store_fee_allocation']);
        Route::name('fetch_fee_allocation')->get('/fetch_fee_allocation', [Fee_setupController::class,'fetch_fee_allocation']);
        Route::name('delete_fee_allocation')->post('/delete_fee_allocation', [Fee_setupController::class,'delete_fee_allocation']);
        Route::name('delete_fee_types')->post('/delete_fee_types', [Fee_setupController::class,'delete_fee_types']);
        Route::name('store_fee_discount')->post('/store_fee_discount', [Fee_setupController::class,'store_fee_discount']);
        Route::name('fetch_fee_discount')->get('/fetch_fee_discount', [Fee_setupController::class,'fetch_fee_discount']);
        Route::name('delete_fee_discount')->post('/delete_fee_discount', [Fee_setupController::class,'delete_fee_discount']);
        Route::name('fetch_student_details')->get('/fetch_student_details', [Fee_setupController::class,'fetch_student_details']);
        Route::name('store_fee_item')->post('/store_fee_item', [Fee_setupController::class,'store_fee_item']);
        Route::name('delete_fee_items')->post('/delete_fee_items', [Fee_setupController::class,'delete_fee_items']);
        Route::name('fetch_fee_item')->get('/fetch_fee_item', [Fee_setupController::class,'fetch_fee_item']);
        /***
         * 
         * PAYMENT TRANSACTIONS
         * 
         */
        Route::name('fetch_daily_total_transaction_amount')->get('/fetch_daily_total_transaction_amount', [TransactionController::class, 'fetch_daily_total_transaction_amount']);
        Route::name('transactions')->get('/transactions', [TransactionController::class, 'index']);
        Route::name('fetch_allocated_fee_amount')->get('/fetch_allocated_fee_amount', [TransactionController::class, 'fetch_allocated_fee_amount']);  
        Route::name('fetch_fee_revenues')->get('/fetch_fee_revenues', [TransactionController::class, 'fetch_fee_transactions']);
        Route::name('store_fee_revenue')->post('/store_fee_revenue', [TransactionController::class, 'store_fee_revenue']);
        Route::name('find_transaction')->post('/find_transaction', [TransactionController::class, 'find_transaction']);
        Route::name('update_transaction')->post('/update_transaction', [TransactionController::class, 'update_transaction']);
        Route::name('delete_transactions')->post('/delete_transactions', [TransactionController::class, 'delete_transactions']);
        Route::name('fetch_updated_transaction_balance_records')->get('/fetch_updated_transaction_balance_records', [TransactionController::class, 'fetch_updated_fee_transaction_balance_records']);

        /***
         * SEARCH TRANSACTION ROUTE
         */
        Route::name('search_trxn')->post('/search_trxn', [TransactionController::class, 'search_transaction_record']);

        /***
         * DELETED TRANSACTION ROUTES
         */
        Route::name('deleted_transactions')->get('/trashed_transactions', [DeletedTransactionController::class,'deleted_transactions_page']);
        Route::name('fetch_trashed_transaction')->get('/fetch_trashed_transaction', [DeletedTransactionController::class,'fetch_trashed_transaction']);
        Route::name('undo_trashed_transaction')->post('/undo_trashed_transaction', [DeletedTransactionController::class,'undo_trashed_transaction']);
        
        /***
         * 
         * EXPENDITURES ROUTES
         */
        Route::name('expenditures')->get('/expenditures', [ExpensesController::class,'index']);
        Route::name('store_expenses')->post('/store_expenses', [ExpensesController::class,'store_expenses']);
        Route::name('fetch_all_expenditures')->get('/fetch_all_expenditures', [ExpensesController::class,'fetch_all_expenditures']);
        Route::get('/fetch_total_expenditure_amount', [ExpensesController::class,'fetch_total_expenditure_amount']);
        Route::name('delete_expenditures')->post('/delete_expenditures', [ExpensesController::class,'delete_expenditures']);
        
        /**
         * TRANSACTION HISTORY
         */
        Route::name('transaction_history')->get('/transaction_history', [TransactionHistoryController::class,'index']);
        Route::name('fetch_transaction_history')->get('/fetch_transaction_history', [TransactionHistoryController::class,'fetch_transaction_history']);
        Route::name('fetch_transaction_history_total_amounts')->get('/fetch_transaction_history_total_amounts', [TransactionHistoryController::class,'fetch_transaction_history_total_amounts']);
        
        /***
         * NET REVENUE 
         */
        Route::name('net_revenue')->get('/net_income_report', [NetIncomeController::class,'index']);

        /**
         * Invoice Routes
         */
        Route::name('invoice')->get('/invoice', [InvoiceController::class,'index']);

        /**
         * Inventory Routes
         */
        Route::name('inventory')->get('/inventory', [InventoryController::class,'index']);
    });

    Route::prefix('auth0')->group( function(){
        /***
         * ==== Students management routes ==
         */
        Route::name('students_management')->get('/students_management', [StudentsController::class,'index']);
        Route::name('student-delete')->delete('/student-delete/{id}', [StudentsController::class,'destroy']);
        Route::name('student-edit')->get('/student-edit/{id}', [StudentsController::class,'show']);
        Route::name('update-student')->patch('/update-student/{id}', [StudentsController::class,'update']);
        Route::name('register_student')->post('/register_student', [StudentsController::class,'register_student']);
        Route::name('create_webmail_account')->get('/create_webmail_account', [StudentsController::class,'create_webmail_account']);
        /****
         * ==== Staff Management routes ===
         */
        Route::name('register_staff')->post('/register_staff', [StaffController::class,'register_staff']);
        Route::name('staff_management')->get('/staff_management', [StaffController::class,'index']);
        Route::name('delete_users')->post('/delete_users', [IndexController::class,'delete_users']);
        Route::name('staff-password')->get('/staff-password/{id}', [StaffController::class,'show']);
        Route::name('change-staff-password')->patch('/change-staff-password/{id}', [StaffController::class,'update']);
        Route::name('remove_staff_as_admin')->post('/remove_staff_as_admin', [StaffController::class,'remove_staff_as_admin']); 
        Route::name('remove_staff_as_accountant')->post('/remove_staff_as_accountant', [StaffController::class,'remove_staff_as_accountant']);
        Route::name('remove_staff_as_sub_admin')->post('/remove_staff_as_sub_admin', [StaffController::class,'remove_staff_as_sub_admin']); 
        Route::name('make_staff_admin')->post('/make_staff_admin', [StaffController::class,'make_staff_admin']); 
        Route::name('make_staff_accountant')->post('/make_staff_accountant', [StaffController::class,'make_staff_accountant']);
        Route::name('make_staff_sub_admin')->post('/make_staff_sub_admin', [StaffController::class,'make_staff_sub_admin']);
        Route::name('form_teachers')->get('/form_teachers', [StaffController::class,'form_teachers']);
        Route::name('subject_teachers')->get('/subject_teachers', [StaffController::class,'subject_teachers']); 
        Route::name('my_form_class')->get('/my_class_', [StaffController::class,'my_form_class']); 
        Route::name('remove_form_teacher')->get('/remove_form_teacher', [StaffController::class,'remove_form_teacher']);
        Route::name('remove_subject_teacher')->get('/remove_subject_teacher', [StaffController::class,'remove_subject_teacher']);
        Route::name('register_new_form_teacher')->post('/register_new_form_teacher', [StaffController::class,'register_new_form_teacher']);
        Route::name('register_new_subject_teacher')->post('/register_new_subject_teacher', [StaffController::class,'register_new_subject_teacher']);
        Route::name('fetch_students_of_this_class')->get('/fetch_students_of_this_class', [StaffController::class,'fetch_students_of_this_class']);
        /***
         ** RESULT MANAGEMENT 
         ***/
        Route::name('view_result_page')->get('/view-results_', [ResultController::class,'view_result_page']);
        Route::name('compute_subject_result')->get('/compute-subject-result', [ResultController::class,'compute_subject_result']);
        Route::name('compute_result')->get('/compute-result', [ResultController::class,'compute_result_page']);
        Route::name('class_broadsheet')->get('/class-broadsheet', [ResultController::class,'view_class_broadsheet']);
        Route::name('subject_result')->get('/subject-result', [ResultController::class,'subject_result']);
        Route::name('store_students_result')->post('/store-students-result', [ResultController::class,'store_students_result']);
        Route::name('delete_subject_result')->get('/delete-subject-result', [ResultController::class,'delete_subject_result']);
        Route::name('update_subject_result')->post('/update-subject-result', [ResultController::class,'update_subject_result']);
        Route::name('student_progress_report')->get('/progress-report', [ResultController::class,'view_student_progress_report']);
        /**
        * === Settings Routes ====
        **/
        Route::name('change_password_page')->get('/change_password_page', [SettingsController::class,'change_password_page']);
        Route::name('change_password')->post('change_password', [SettingsController::class,'change_password']);
        Route::name('settings')->get('/academic-settings', [SettingsController::class,'show_academic_settings_page']);
        Route::name('show_grade_settings_page')->get('/grade-settings', [SettingsController::class,'show_grade_settings_page']);
        Route::name('show_subject_settings_page')->get('/subject-settings', [SettingsController::class,'show_subject_settings_page']);
        Route::name('show_class_arm_settings_page')->get('/class-arm-settings', [SettingsController::class,'show_class_arm_settings_page']);

        Route::name('store_grade')->post('/store-grade', [SettingsController::class,'store_grade']);
        Route::name('delete_grade')->get('/delete-grade', [SettingsController::class,'delete_grade']);

        Route::name('store_subject')->post('/store-subject', [SettingsController::class,'store_subject']);
        Route::name('delete_subject')->get('/delete-subject', [SettingsController::class,'delete_subject']);

        Route::name('store_class')->post('/store-class_', [SettingsController::class,'store_class_']);
        Route::name('delete_class_')->get('/delete-class_', [SettingsController::class,'delete_class_']);

        Route::name('store_arm')->post('/store-arm_',  [SettingsController::class,'store_arm_']);
        Route::name('delete_arm_')->get('/delete-arm_', [SettingsController::class,'delete_arm_']);

        Route::name('register_academic_session')->post('/register_academic_session', [SettingsController::class,'register_academic_session']);
        Route::name('activate_academic_session')->post('/activate_academic_session', [SettingsController::class,'activate_academic_session']);
        Route::name('de_activate_academic_session')->post('/de_activate_academic_session', [SettingsController::class,'de_activate_academic_session']);
        Route::name('delete_academic_session')->post('/delete_academic_session', [SettingsController::class,'delete_academic_session']);
        Route::name('register_classes')->post('/register_classes', [SettingsController::class,'register_classes']);
        Route::name('register_arms')->post('/register_arms', [SettingsController::class,'register_arms']);
        Route::name('delete_class')->post('/delete_class', [SettingsController::class,'delete_class']);
        Route::name('delete_arms')->post('/delete_arms', [SettingsController::class,'delete_arms']);
        Route::name('undo_published_result')->post('/undo_published_result', [SettingsController::class,'undo_published_result']);
        Route::name('publish_result')->post('/publish_result', [SettingsController::class,'publish_result']);
        
    });

Route::name('print_receipt')->get('/print-receipt', [ReceiptController::class,'index']);
Route::name('my_payments')->get('/my-payments', [ReceiptController::class,'my_payments']);

