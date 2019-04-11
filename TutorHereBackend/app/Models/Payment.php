<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:01 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Payment
 * 
 * @property int $idPayment
 * @property int $Tuition_Request_idRequest
 * @property int $method
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\Tuition $tuition
 *
 * @package App\Models
 */
class Payment extends Eloquent
{
	protected $table = 'payment';
	public $timestamps = false;

	protected $casts = [
		'Tuition_Request_idRequest' => 'int',
		'method' => 'int'
	];

	protected $fillable = [
		'method'
	];

	public function tuition()
	{
		return $this->belongsTo(\App\Models\Tuition::class, 'Tuition_Request_idRequest');
	}
}
