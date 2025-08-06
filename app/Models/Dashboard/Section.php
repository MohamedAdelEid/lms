<?php

namespace App\Models\Dashboard;

use App\Models\Admin\Admin;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public $table = "sections";
    public $timestamps = true;
    protected $fillable = [
        'section_name',
        'number_of_lectures',
        'course_id',
        'admin_id',
    ];
    public function lectures(){
        return $this->hasMany(Lecture::class);
    }
    public function course(){
        return $this->belongsTo(Course::class ,'course_id' ,'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_courses_sections', 'section_id', 'user_id')
            ->withPivot('course_id');
    }

    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    public function scopeSearch($query,$value){
        $query->where('section_name','like',"%{$value}%")
              ->orwhere('number_of_lectures','like',"%{$value}%")
              ->orWhereHas('course',function ($subQuery) use($value){
               $subQuery->where('course_title','like',"%{$value}%");
              })
            ->orWhereHas('admin',function ($subQuery) use($value){
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"]);
            });
    }
}
