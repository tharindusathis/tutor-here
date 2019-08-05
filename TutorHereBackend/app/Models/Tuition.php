<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:11 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Tuition
 *
 * @property int $Request_idRequest
 * @property int $status
 * @property int $duration
 * @property \Carbon\Carbon $created_at
 *
 * @property \App\Models\Request $request
 * @property \Illuminate\Database\Eloquent\Collection $payments
 * @property \App\Models\Review $review
 *
 * @package App\Models
 */
class Tuition extends Eloquent
{
	protected $table = 'tuition';
	protected $primaryKey = 'Request_idRequest';
	public $incrementing = false;
	public $timestamps = true;

	protected $casts = [
		'Request_idRequest' => 'int',
		'status' => 'int',
		'duration' => 'int'
	];

	protected $fillable = [
		'status',
		'duration',
		'Request_idRequest'
	];

	public function request()
	{
		return $this->belongsTo(\App\Models\Request::class, 'Request_idRequest');
	}

	public function payments()
	{
		return $this->hasMany(\App\Models\Payment::class, 'Tuition_Request_idRequest');
	}

	public function review()
	{
		return $this->hasOne(\App\Models\Review::class, 'Tuition_Request_idRequest');
	}
}
