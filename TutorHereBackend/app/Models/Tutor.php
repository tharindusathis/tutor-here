<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Tutor
 * 
 * @property int $idTutor
 * @property int $status
 * @property string $fname
 * @property string $lname
 * @property string $email
 * @property string $mobile
 * @property string $password
 * @property float $account_balance
 * @property string $currency_type
 * 
 * @property \Illuminate\Database\Eloquent\Collection $qualifications
 * @property \Illuminate\Database\Eloquent\Collection $singletimeslots
 * @property \Illuminate\Database\Eloquent\Collection $subjects
 * @property \Illuminate\Database\Eloquent\Collection $tutorlocations
 * @property \Illuminate\Database\Eloquent\Collection $weeklytimeslots
 *
 * @package App\Models
 */
class Tutor extends Eloquent
{
	protected $table = 'tutor';
	protected $primaryKey = 'idTutor';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'account_balance' => 'float'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'status',
		'fname',
		'lname',
		'email',
		'mobile',
		'password',
		'account_balance',
		'currency_type'
	];

	public function qualifications()
	{
		return $this->hasMany(\App\Models\Qualification::class, 'Tutor_idTutor');
	}

	public function singletimeslots()
	{
		return $this->hasMany(\App\Models\Singletimeslot::class, 'Tutor_idTutor');
	}

	public function subjects()
	{
		return $this->belongsToMany(\App\Models\Subject::class, 'tutor_has_subject', 'Tutor_idTutor', 'Subject_idSubject')
					->withPivot('hourly_rate');
	}

	public function tutorlocations()
	{
		return $this->hasMany(\App\Models\Tutorlocation::class, 'Tutor_idTutor');
	}

	public function weeklytimeslots()
	{
		return $this->hasMany(\App\Models\Weeklytimeslot::class, 'Tutor_idTutor');
	}
}
