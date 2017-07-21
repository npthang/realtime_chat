<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level', 'fullname','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function searchableAs()
    {
        return 'users_index';
    }

    public function roomusers()
    {
        return $this->hasMany('App\Room-User');
    }

    public function messengeses()
    {
        return $this->hasMany('App\Messenges');
    }

    public function privatemessengeses()
    {
        return $this->hasMany('App\PrivateMessage');
    }
}
