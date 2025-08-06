<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = ['category_name'];
    public $timestamps = true;

    public function Courses(){
        return $this->hasMany(Course::class);
    }
    public function scopeSearch($query,$value){
        $query->where('category_name','like',"%{$value}%");
    }
}
