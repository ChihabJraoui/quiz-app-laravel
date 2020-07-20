<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'email', 'password', 'firstname', 'lastname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


	/*
	 *  RelationShips
	 */

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function subjects()
	{
		return $this->hasMany(Subject::class);
	}


    /*
     *  HELPERS
     */

    public function getFullName()
    {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }

    public function getPicture()
    {
    	if(empty($this->attributes['picture']))
	    {
	    	return asset('img/default_user.png');
	    }
	    else
	    {
	    	return asset('img/users/' . $this->attributes['picture']);
	    }
    }

}
