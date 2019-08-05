<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Request
 *
 * @property int $idRequest
 * @property int $status
 * @property int $Tutor_has_Subject_Tutor_idTutor
 * @property int $Tutor_has_Subject_Subject_idSubject
 * @property int $Learner_idLearner
 * @property int $LearnerLocation_idLearnerLocation
 * @property float $payment
 * @property \Carbon\Carbon $datetime
 * @property int $duration
 * @property \Carbon\Carbon $created_at
 *
 * @property \App\Models\Learner $learner
 * @property \App\Models\Learnerlocation $learnerlocation
 * @property \App\Models\TutorHasSubject $tutor_has_subject
 * @property \App\Models\Tuition $tuition
 *
 * @package App\Models
 */
class Request extends Eloquent
{
	protected $table = 'request';

	protected $primaryKey = 'idRequest';
	public $timestamps = true;

	protected $casts = [
		'status' => 'int',
		'Tutor_has_Subject_Tutor_idTutor' => 'int',
		'Tutor_has_Subject_Subject_idSubject' => 'int',
		'Learner_idLearner' => 'int',
		'LearnerLocation_idLearnerLocation' => 'int',
		'payment' => 'float',
		'dist' => 'float',
		'duration' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'status',
		'payment',
		'date',
		'duration',
		'start_time',
		'end_time',
		'idTimeslot',
		'Tutor_has_Subject_Tutor_idTutor',
		'Tutor_has_Subject_Subject_idSubject',
		'Learner_idLearner',
		'LearnerLocation_idLearnerLocation',
		'dist'
	];

	public function learner()
	{
		return $this->belongsTo(\App\Models\Learner::class, 'Learner_idLearner');
	}

	public function learnerlocation()
	{
		return $this->belongsTo(\App\Models\Learnerlocation::class, 'LearnerLocation_idLearnerLocation');
	}

	public function tutor_has_subject()
	{
		return $this->belongsTo(\App\Models\TutorHasSubject::class, 'Tutor_has_Subject_Tutor_idTutor')
					->where('tutor_has_subject.Tutor_idTutor', '=', 'request.Tutor_has_Subject_Tutor_idTutor')
					->where('tutor_has_subject.Subject_idSubject', '=', 'request.Tutor_has_Subject_Subject_idSubject');
	}

	public function tuition()
	{
		return $this->hasOne(\App\Models\Tuition::class, 'Request_idRequest');
	}
}
