<?php

namespace app\Http\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package app\Http\Models
 */
abstract class BaseModel extends Model {
	use CamelCasing;
}