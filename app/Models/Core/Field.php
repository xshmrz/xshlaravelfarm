<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Core;

use App\Traits\TraitUpload;
use Bjerke\ApiQueryBuilder\QueryBuilderModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Field
 * 
 * @property int $id
 * @property int|null $location_id
 * @property int|null $user_id
 * @property string|null $name
 * @property float|null $area
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Location|null $location
 * @property User|null $user
 *
 * @package App\Models\Core
 */
class Field extends Model
{
	use SoftDeletes;
	use QueryBuilderModelTrait;
	use TraitUpload;
	const ID = 'id';
	const LOCATION_ID = 'location_id';
	const USER_ID = 'user_id';
	const NAME = 'name';
	const AREA = 'area';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	const DELETED_AT = 'deleted_at';
	protected $table = 'field';

	protected $columns = [
		'id',
		'location_id',
		'user_id',
		'name',
		'area',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	protected $casts = [
		self::ID => 'int',
		self::LOCATION_ID => 'int',
		self::USER_ID => 'int',
		self::AREA => 'float',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::LOCATION_ID,
		self::USER_ID,
		self::NAME,
		self::AREA
	];

	public function location(): BelongsTo
	{
		return $this->belongsTo(Location::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
