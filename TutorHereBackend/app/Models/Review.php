<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Apr 2019 05:12:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Review
 *
 * @property int $Tuition_Request_idRequest
 * @property int $rating
 * @property string $text
 *
 * @property \App\Models\Tuition $tuition
 *
 * @package App\Models
 */
class Review extends Eloquent
{
	protected $table = 'review';
	protected $primaryKey = 'Tuition_Request_idRequest';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Tuition_Request_idRequest' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'rating',
		'text',
		'Tuition_Request_idRequest'
	];

	public function tuition()
	{
		return $this->belongsTo(\App\Models\Tuition::class, 'Tuition_Request_idRequest');
	}
}
