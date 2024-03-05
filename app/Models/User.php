<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    const ROLE_ROOT = 0;
    const ROLE_ADMIN = 1;
    const ROLE_DIRECTOR = 2;
    const ROLE_TEACHER = 3;
    const ROLE_USER = 4;

    public static function  getRoles() {
        return [
            self::ROLE_ROOT => 'Root пользователь',
            self::ROLE_ADMIN => 'Супер пользователь',
            self::ROLE_USER => 'пользователь'
        ];
    }

    public function like(){
        return $this->belongsTo(Like::class);
    }
    public function post(){
        return $this->hasMany(Post::class);
    }
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
     public function getJWTIdentifier(){
        return $this->getKey();
     }


     public function getJWTCustomClaims(){
        return [];
     }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
