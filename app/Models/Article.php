<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',      // Allows mass assignment of the title
        'content',    // Allows mass assignment of the content
        'user_id',    // Allows mass assignment of the associated user ID
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
