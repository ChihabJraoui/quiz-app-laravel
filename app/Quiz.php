<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
	use SoftDeletes;

    protected $table = 'quizzes';

    protected $fillable = ['subject_id', 'name'];

    /*
     * relationships
     */

    public function subject()
    {
    	return $this->belongsTo(Subject::class);
    }

    public function students()
    {
    	return $this->belongsToMany(Student::class, 'quiz_user', 'quiz_id', 'user_id');
    }
}
