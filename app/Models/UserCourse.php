<?php

namespace App\Models;

use App\Models\Dashboard\Course;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;
    protected $primaryKey = ['user_id', 'course_id'];
    public $incrementing = false;
    public $table = '_student_course';
    protected $fillable=[
        'user_id',
        'course_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
