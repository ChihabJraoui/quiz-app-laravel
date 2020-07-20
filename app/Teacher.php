<?php

namespace App;

class Teacher extends User
{
    protected $table = 'users';

	/*
	 *  RelationShips
	 */

	public function quizzes()
	{
		return $this->hasManyThrough(Quiz::class, Subject::class, 'user_id');
	}
}
