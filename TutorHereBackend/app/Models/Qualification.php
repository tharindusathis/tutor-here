<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Qualification
 * 
 * @property int $idQualification
 * @property int $Tutor_idTutor
 * @property string $name
 * @property string $text
 * @property string $from
 * 
 * @property \App\Models\Tutor $tutor
 *
 * @package App\Models
 */
class Qualification extends Eloquent
{
	protected $table = 'qualification';
	public $timestamps = false;

	protected $casts = [
		'Tutor_idTutor' => 'int'
	];

	protected $fillable = [
		'name',
		'text',
		'from'
	];

	public function tutor()
	{
		return $this->belongsTo(\App\Models\Tutor::class, 'Tutor_idTutor');
	}
}
