<?php

namespace App\Models\Dashboard;

use App\Models\Admin\Admin;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $appends = ['videos_count'];
    public const STATUS_ACTIVE = 'active';
    public const STATUS_UPCOMING = 'upcoming';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DEACTIVATED = 'deactivated';
    public $table = "courses";
    public $timestamps = true;
    protected $fillable = [
      'course_title',
      'course_description',
      'status',
       'cover_image',
      'price',
      'admin_id',
      'category_id',
      'instructor_id',
    ];
    public function getVideosCountAttribute()
    {
        $videoCount = 0;
        foreach ($this->sections as $section) {
            foreach ($section->lectures as $lecture) {
                $videoCount += $lecture->videos->count();
            }
        }
        return $videoCount;
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function userSections()
    {
        return $this->belongsToMany(User::class, 'users_courses_sections')
            ->withPivot('section_id');
    }
    public function videos()
    {
        return $this->hasManyThrough(Video::class, Lecture::class, 'section_id', 'lecture_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public static function getStatusOptions():array
    {
        return [
          self::STATUS_ACTIVE => 'Active',
          self::STATUS_UPCOMING => 'UpComing',
          self::STATUS_COMPLETED => 'Completed',
          self::STATUS_DEACTIVATED => 'Deactivated',
        ];
    }
    public function scopeSearch($query,$value){
        $query->where('course_title','like',"%{$value}%")
              ->orWhere('price', 'like', "%{$value}%")
              ->orWhere('status', 'like', "%{$value}%")
              ->orWhere('course_description', 'like', "%{$value}%")
            ->orWhereHas('admin', function ($subQuery) use ($value) {
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"]);
            })
            ->orWhereHas('category', function ($subQuery) use ($value) {
                $subQuery->where('category_name', 'like', "%{$value}%");
            })
            ->orWhereHas('instructor',function ($subQuery) use($value){
                $subQuery->whereRaw("CONCAT(first_name,' ',last_name) LIKE ?", ["%{$value}%"]);
            });
    }
}
