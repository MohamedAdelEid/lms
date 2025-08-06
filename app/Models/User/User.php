<?php

namespace App\Models\User;

use App\Models\Admin\Admin;

use App\Models\Dashboard\Course;
use App\Models\Dashboard\Discussions;
use App\Models\Dashboard\Section;
use App\Models\UserCourse;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements AuthenticatableContract
{
    use HasApiTokens, HasFactory, Notifiable;
    public $table = 'users';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'phone_number',
        'admin_id',
        'is_blocked'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    public function discussions(){
        return $this->hasMany(Discussions::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'users_courses_sections', 'user_id', 'course_id')
            ->withPivot('section_id');
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'users_courses_sections', 'user_id', 'section_id')
            ->withPivot('course_id');
    }

    public function scopeSearch($query,$value){
        $query->where('name','like',"%{$value}%")
              ->orWhere('email', 'like', "%{$value}%")
              ->orWhere('is_blocked','like',"%{$value}%")
              ->orWhere('phone_number', 'like', "%{$value}%")
              ->orWhereHas('admin', function ($subQuery) use ($value) {
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"]);
            });
    }
}
