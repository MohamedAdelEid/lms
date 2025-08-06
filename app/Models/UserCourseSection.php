<?php

namespace App\Models;

use App\Models\Dashboard\Course;
use App\Models\Dashboard\Section;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseSection extends Model
{
    use HasFactory;

    protected $table = 'users_courses_sections';

    protected $fillable = [
        'user_id',
        'course_id',
        'section_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
