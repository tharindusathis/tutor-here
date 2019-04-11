<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:00 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Learnerlocation
 * 
 * @property int $idLearnerLocation
 * @property int $Learner_idLearner
 * @property string $address
 * @property string $city
 * @property string $disstrict
 * @property float $lat
 * @property float $lng
 * 
 * @property \App\Models\Learner $learner
 * @property \Illuminate\Database\Eloquent\Collection $requests
 *
 * @package App\Models
 */
class Learnerlocation extends Eloquent
{
	protected $table = 'learnerlocation';
	public $timestamps = false;

	protected $casts = [
		'Learner_idLearner' => 'int',
		'lat' => 'float',
		'lng' => 'float'
	];

	protected $fillable = [
		'address',
		'city',
		'disstrict',
		'lat',
		'lng'
	];

	public function learner()
	{
		return $this->belongsTo(\App\Models\Learner::class, 'Learner_idLearner');
	}

	public function requests()
	{
		return $this->hasMany(\App\Models\Request::class, 'LearnerLocation_idLearnerLocation');
	}
}
