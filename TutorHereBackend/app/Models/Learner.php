<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:11:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Learner
 *
 * @property int $idLearner
 * @property int $status
 * @property string $fname
 * @property string $lname
 * @property string $email
 * @property string $mobile
 * @property string $password
 * @property float $account_balance
 * @property string $currency_type
 *
 * @property \Illuminate\Database\Eloquent\Collection $subjects
 * @property \Illuminate\Database\Eloquent\Collection $learnerlocations
 * @property \Illuminate\Database\Eloquent\Collection $requests
 *
 * @package App\Models
 */
class Learner extends Eloquent
{
	protected $table = 'learner';
	protected $primaryKey = 'idLearner';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'account_balance' => 'float'
	];

	protected $hidden = [
		//'password'
	];

	protected $fillable = [
		'status',
		'fname',
		'lname',
		'email',
		'mobile',
		'account_balance',
		'currency_type'
	];

	public function subjects()
	{
		return $this->belongsToMany(\App\Models\Subject::class, 'learner_has_subject', 'Learner_idLearner', 'Subject_idSubject');
	}

	public function learnerlocations()
	{
		return $this->hasMany(\App\Models\Learnerlocation::class, 'Learner_idLearner');
	}

	public function requests()
	{
		return $this->hasMany(\App\Models\Request::class, 'Learner_idLearner');
	}
}
