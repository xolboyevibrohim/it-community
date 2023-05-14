<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','description','file_url','category_id'];
    public function scopeUserPost($query)
    {
        return $query->where('user_id',Auth::id());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
