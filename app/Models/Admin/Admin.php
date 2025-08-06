<?php

namespace App\Models\Admin;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Instructor;
use App\Models\Dashboard\Lecture;
use App\Models\Dashboard\Section;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'profile_picture',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function Courses(){
        return $this->hasMany(Course::class);
    }
    public function sections(){
        return $this->hasMany(Section::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
    public function instructors(){
        return $this->hasMany(Instructor::class);
    }
    public function lectures(){
        return $this->hasMany(Lecture::class);
    }


}
