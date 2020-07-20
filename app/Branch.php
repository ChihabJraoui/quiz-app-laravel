<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Branch extends Model
{

	protected $table = 'branches';



	/*
	 *  RelationShips
	 */

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function subjects()
	{
		return $this->hasMany(Subject::class);
	}

	public function quizzes()
	{
		return $this->hasManyThrough(Quiz::class, Subject::class);
	}

}