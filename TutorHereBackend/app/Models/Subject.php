<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subject
 * 
 * @property int $idSubject
 * @property int $status
 * @property string $name
 * @property string $grade
 * @property string $syllabus_from
 * @property \Carbon\Carbon $syllabus_year
 * 
 * @property \Illuminate\Database\Eloquent\Collection $learners
 * @property \Illuminate\Database\Eloquent\Collection $tutors
 *
 * @package App\Models
 */
class Subject extends Eloquent
{
	protected $table = 'subject';
	protected $primaryKey = 'idSubject';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $dates = [
		'syllabus_year'
	];

	protected $fillable = [
		'status',
		'name',
		'grade',
		'syllabus_from',
		'syllabus_year'
	];

	public function learners()
	{
		return $this->belongsToMany(\App\Models\Learner::class, 'learner_has_subject', 'Subject_idSubject', 'Learner_idLearner');
	}

	public function tutors()
	{
		return $this->belongsToMany(\App\Models\Tutor::class, 'tutor_has_subject', 'Subject_idSubject', 'Tutor_idTutor')
					->withPivot('hourly_rate');
	}
}
