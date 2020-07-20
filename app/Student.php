<?php

namespace App;

class Student extends User
{

	protected $table = 'users';

	/*
	 *  Relationships
	 */

	public function quizzes()
	{
		return $this->belongsToMany(Quiz::class, 'quiz_user', 'user_id', 'quiz_id')
			->withPivot('score')->withTimestamps();
	}

}
