<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Tutorlocation
 *
 * @property int $idTutorLocation
 * @property int $Tutor_idTutor
 * @property string $city
 * @property float $lat
 * @property float $lng
 *
 * @property \App\Models\Tutor $tutor
 *
 * @package App\Models
 */
class Tutorlocation extends Eloquent
{
	protected $table = 'tutorlocation';
	public $timestamps = false;

	protected $casts = [
		'Tutor_idTutor' => 'int',
		'lat' => 'float',
		'lng' => 'float'
	];

	protected $fillable = [
		'Tutor_idTutor',
		'city',
		'lat',
		'lng'
	];

	public function tutor()
	{
		return $this->belongsTo(\App\Models\Tutor::class, 'Tutor_idTutor');
	}
}
