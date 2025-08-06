<?php

namespace App\Models\Dashboard;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $table = 'lectures';
    public $timestamps = true;
    protected $fillable = [
        'lecture_name',
        'lecture_description',
        'section_id',
        'admin_id',
    ];
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    public function discussions(){
        return $this->hasMany(Discussions::class);
    }
    public function scopeSearch($query,$value){
        $query->where('lecture_name','like',"%{$value}%")
              ->orWhereHas('section',function($subQuery) use($value){
                  $subQuery->where('section_name','like',"%{$value}%");
              })
             ->orWhereHas('admin',function ($subQuery) use($value){
                 $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"]);
             });
    }
}
