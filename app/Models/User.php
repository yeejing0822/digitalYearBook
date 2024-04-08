<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Setup Many-to-Many relationship 
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
    *   Check if the user has a role
    *   @param string $role
    *   @return bool
    */
    public function hasAnyRole($role)
    {
        // check whether the name column is refer to the role 
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
    *   Check the user has any given role
    *   @param array $role
    *   @return bool
    */
    public function hasAnyRoles($role)
    {
        // check whether any role array is in the name column
        return null !== $this->roles()->whereIn('name', $role)->first();
    }

    //getSubscription indicates one user has many subscription and many subscription have an artwork
    public function getSubscription()
    {
        return $this->hasManyThrough(Artwork::class, Subscription::class);
    }
}
