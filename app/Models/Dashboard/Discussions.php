<?php

namespace App\Models\Dashboard;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussions extends Model
{
    use HasFactory;
    protected $casts = [
        'likes' => 'integer',
    ];

    protected $fillable = [
        'message',
        'message_date',
        'user_id',
        'lecture_id',
        'likes'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lecture(){
        return $this->belongsTo(Lecture::class);
    }
}
