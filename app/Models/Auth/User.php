<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

/**
 * Class User.
 */
class User extends BaseUser implements JWTSubject
{
    use UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;

    public function getBrandUsers(){
        return $this->hasMany('App\Models\Auth\User' , 'parent_id' , 'id');
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

    /**
     * @return string
     */
    public function getClientCustomerIdAttribute()
    {
        if ($this->attributes['parent_id'] != null){

            return $this->parent->client_customer_id;
        }

        return $this->attributes['client_customer_id'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getParentAttribute()
    {
        return User::query( )->where('id',  $this->attributes['parent_id'] )->first();
    }

}
