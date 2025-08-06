<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'video_path',
        'lecture_id',
        'cover_image'
    ];
    public function lecture(){
        $this->belongsTo(Lecture::class);
    }
}
