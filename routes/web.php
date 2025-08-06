<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\NoCacheMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('login-admin',[AdminController::class,'login_form'])->name('login.form');
Route::post('login-functionality',[AdminController::class,'login_functionality'])->name('login.functionality');

Route::middleware(['admin','noCache'])->group(function () {
    Route::get('myprofile', [AdminController::class, 'myProfile'])->name('admin.myProfile');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::group(['middleware'=>'admin'],function() {
    Route::get('myprofile', [AdminController::class, 'myProfile'])->name('admin.myProfile');
    Route::post('update-or-delete-profile-picture',[AdminController::class,'updateOrDeleteProfilePicture'])->name('admin.updateOrDeleteProfilePicture');
    Route::post('/update-profile-picture', [AdminController::class, 'updateProfilePicture'])->name('admin.updateProfilePicture');
    Route::post('/delete-profile-picture', [AdminController::class, 'deleteProfilePicture'])->name('admin.deleteProfilePicture');
    Route::post('/changepersonaldetails', [AdminController::class, 'changePersonalDetails'])->name('admin.changePersonalDetails');
    Route::post('/changepassword', [AdminController::class, 'changePassword'])->name('admin.ChangePassword');

});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'],function (){
    //categoriesRoutes
    Route::get('addcategory',[CategoryController::class,'addCategory'])->name('admin.addCategory');
    Route::post('storecategory',[CategoryController::class,'storeCategory'])->name('admin.storeCategory');
    Route::get('categories/{id}',[CategoryController::class,'viewEditCategory'])->name('admin.editCategory');
    Route::put('editcategory/{id}',[CategoryController::class,'editCategory'])->name('edit.editCategory');


    //CoursesRoutes
   Route::get('addcourse',[CourseController::class,'addCourse'])->name('admin.addCourse');
   Route::post('storecourse',[CourseController::class,'storeCourse'])->name('admin.storeCourse');
    Route::get('editcourse/{id}',[CourseController::class,'viewEditCourse'])->name('admin.editCourse');
    Route::put('editcourse/{id}',[CourseController::class,'editCourse'])->name('edit.editCourse');



    //SectionsRoutes
   Route::get('addsection',[SectionController::class,'addSection'])->name('admin.addSection');
   Route::post('storesection',[SectionController::class,'storeSection'])->name('admin.storeSection');
    Route::get('editsection/{id}',[SectionController::class,'viewEditSection'])->name('admin.editSection');
    Route::put('editsection/{id}',[SectionController::class,'editSection'])->name('edit.editSection');

    //LecturesRoutes
   Route::get('addlecture',[LectureController::class,'addLecture'])->name('admin.addLecture');
   Route::post('storelecture',[LectureController::class,'storeLecture'])->name('admin.storeLecture');
    Route::get('editlecture/{id}',[LectureController::class,'viewEditLecture'])->name('admin.editLecture');
    Route::put('editlecture/{id}',[LectureController::class,'editLecture'])->name('edit.editLecture');
    Route::get('lecture/{id}/video/{video?}', [LectureController::class, 'viewLectureVideo'])->name('admin.viewLectureVideo');


    //InstructorsRoutes
   Route::get('addinstructor',[InstructorController::class,'addInstructor'])->name('admin.addInstructor');
   Route::post('storeinstructor',[InstructorController::class,'storeInstructor'])->name('admin.storeInstructor');
    Route::get('editeinstructor/{id}',[InstructorController::class,'viewEditInstructor'])->name('admin.editInstructor');
    Route::put('editinstructor/{id}',[InstructorController::class,'editInstructor'])->name('edit.editInstructor');

    //UsersRoutes
   Route::get('adduser',[UserController::class,'addUser'])->name('admin.addUser');
   Route::post('storeuser',[UserController::class,'storeUser'])->name('admin.storeUser');
    Route::get('editeuser/{id}',[UserController::class,'viewEditUser'])->name('admin.editUser');
    Route::put('edituser/{id}',[UserController::class,'editUser'])->name('edit.editUser');
    Route::get('add-course-for-user',[UserController::class,'addCourseToUser'])->name('admin.addCourseToUser');
    Route::post('add-course-for-user',[UserController::class,'storeCourseToUser'])->name('admin.storeCourseToUser');
});

//route to fetch sections with specific course id
Route::post('/admin/fetchSections', [AdminController::class, 'fetchSections'])->name('admin.fetchSections');


Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('viewcategories', [CategoryController::class, 'show'])->name('viewCategories');
    Route::get('viewcourses', [CourseController::class, 'show'])->name('viewCourses');
    Route::get('viewsections', [SectionController::class, 'show'])->name('viewSections');
    Route::get('viewlectures', [LectureController::class, 'show'])->name('viewLectures');
    Route::get('viewinstructors', [InstructorController::class, 'show'])->name('viewInstructors');
    Route::get('viewusers', [UserController::class, 'show'])->name('viewUsers');
});

Route::post('/discussion/{id}/edit', [UserController::class,'edit'])->name('discussion.edit');
Route::post('/discussion/{id}/delete', [UserController::class,'delete'])->name('discussion.delete');

// Users Routes

Route::group(['middleware'=>'auth','prefix'=>'treasure_academy'],function(){
    Route::get('/home', [UserController::class, 'index'])->name('user.home');
    Route::get('/myprofile', [UserController::class, 'myProfile'])->name('user.myProfile');
    Route::get('/contactus', [UserController::class, 'viewContactUs'])->name('user.viewContactUs');
    Route::get('/courses', [UserController::class, 'viewCourses'])->name('user.courses');
    Route::get('/playlist/course_id/{course_id}', [UserController::class, 'viewPlaylist'])->name('user.playlist');
    Route::get('/watch-video/lecture_id/{lecture_id}', [UserController::class, 'watchVideo'])->name('user.watchvideo');
    Route::post('/addcomment/{lecture_id}',[UserController::class,'addComment'])->name('user.addComment');

    Route::get('/edit-user-info',[UserController::class,'editUserInformation'])->name('user.editUserInformation');
    Route::post('/edit-user-info',[UserController::class,'storeEditUserInformation'])->name('user.storeEditUserInformation');
});
//To Handle Ajax Request
Route::post('/like-video', [UserController::class,'likeVideo'])->name('like.video');
Route::post('/treasure_academy/images', [UserController::class,'handleImage'])->name('images.handle')->middleware('auth');


Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth','noCache')
    ->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('treasure_academy/home'); // Change '/home' to your desired route
    });
});
