<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $fillable = ['user_id', 'branch_id', 'name'];

	/*
	 *  RelationShips
	 */

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function questions()
	{
		return $this->hasMany(Question::class);
	}

	public function quizzes()
	{
		return $this->hasMany(Quiz::class);
	}
}