<?php

namespace App\Models\Dashboard;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    public $table = 'instructors';
    public $timestamps = true;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'profile_picture',
        'qualifications',
        'admin_id',
    ];
    public function Courses(){
        return $this->hasMany(Course::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function scopeSearch($query, $value)
    {
        $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"])
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone_number', 'like', "%{$value}%")
            ->orWhere('qualifications', 'like', "%{$value}%")
            ->orWhereHas('admin', function ($subQuery) use ($value) {
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"]);
            });
    }

}
