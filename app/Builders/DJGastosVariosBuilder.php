<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DJGastosVariosCollection;
use App\DJGastosVarios;

/**
 * @method static DJGastosVariosBuilder query()
 * @method static DJGastosVariosBuilder where(string $column,string $operator, string $value)
 * @method static DJGastosVariosBuilder where(string $column,string $value)
 * @method static DJGastosVariosBuilder whereNotNull(string $column)
 * @method static DJGastosVariosBuilder whereNull(string $column)
 * @method static DJGastosVariosBuilder whereIn(string $column,array $array)
 * @method static DJGastosVariosBuilder orderBy(string $column,array $sentido)
 * @method static DJGastosVariosBuilder select(array|string $columns)
 * @method static DJGastosVariosBuilder distinct()
 * @method static DJGastosVariosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DJGastosVariosBuilder whereBetween(string $column, array $values)
 * @method static DJGastosVariosBuilder whereNotBetween(string $column, array $values)
 * @method static DJGastosVariosBuilder whereNotIn(string $column, array $values)
 * @method static DJGastosVariosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DJGastosVariosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DJGastosVariosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DJGastosVariosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DJGastosVariosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DJGastosVariosBuilder groupBy(string ...$groups)
 * @method static DJGastosVariosBuilder limit(int $value)
 * @method static int count()
 * @method static DJGastosVariosCollection get(array|string $columns = ["*"])
 * @method static DJGastosVarios|null first()
 */
class DJGastosVariosBuilder extends Builder {}
