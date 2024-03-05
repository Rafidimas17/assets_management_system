<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MasterUser extends Authenticatable implements JWTSubject
{
    // Your model implementation

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    protected $table = 'master_user';
     protected $fillable = [
        'nama',
        'email',
        'role_id',
        'cabang_id',
        'username',
        'password',       
    ];

    protected $dates = ['deleted_at'];
    
    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->username === null) {
                $username = explode('@', $user->email)[0];
                $newUsername = strtolower($username);

                if (User::where('username', $newUsername)->first()) {
                    $newUsername = Str::random(5);
                }
                $user->username = $newUsername;
                $user->save();
            }
        });
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(MasterRole::class);
    }
    
    public function cabang()
    {
        return $this->belongsTo(MasterCabang::class);
    }

    public function transactions(){
        $this->hasMany(MasterTransaction::class);
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
   
}
