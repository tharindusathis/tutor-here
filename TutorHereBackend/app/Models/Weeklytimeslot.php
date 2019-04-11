<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:16 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Weeklytimeslot
 * 
 * @property int $idWeeklyTimeslot
 * @property int $Tutor_idTutor
 * @property int $week_day
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon $end_time
 * 
 * @property \App\Models\Tutor $tutor
 *
 * @package App\Models
 */
class Weeklytimeslot extends Eloquent
{
	protected $table = 'weeklytimeslot';
	public $timestamps = false;

	protected $casts = [
		'Tutor_idTutor' => 'int',
		'week_day' => 'int'
	];

	protected $dates = [
		'start_time',
		'end_time'
	];

	protected $fillable = [
		'week_day',
		'start_time',
		'end_time'
	];

	public function tutor()
	{
		return $this->belongsTo(\App\Models\Tutor::class, 'Tutor_idTutor');
	}
}
