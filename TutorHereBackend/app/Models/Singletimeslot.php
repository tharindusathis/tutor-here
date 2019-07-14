<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Singletimeslot
 *
 * @property int $idSingleTimeslot
 * @property int $Tutor_idTutor
 * @property \Carbon\Carbon $start_datetime
 * @property \Carbon\Carbon $end_datetime
 *
 * @property \App\Models\Tutor $tutor
 *
 * @package App\Models
 */
class Singletimeslot extends Eloquent
{
	protected $table = 'singletimeslot';
	public $timestamps = false;

	protected $casts = [
		'Tutor_idTutor' => 'int'
	];

	protected $dates = [
		'start_datetime',
		'end_datetime'
	];

	protected $fillable = [
		'start_datetime',
		'end_datetime',
		'Tutor_idTutor'
	];

	public function tutor()
	{
		return $this->belongsTo(\App\Models\Tutor::class, 'Tutor_idTutor');
	}
}
