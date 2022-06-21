<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'department','department');
    }

    public function replies()
    {
        return $this->morphMany(Reply::class,'repliable');
    }

    public function isAdmin()
    {
        return  $this instanceof Admin;
    }


}
