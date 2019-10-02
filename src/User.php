<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = [];

    protected $casts = ['address' => 'json'];

    protected $dates = ['birthday'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'user_id');
    }
}