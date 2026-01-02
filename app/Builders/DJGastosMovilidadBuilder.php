<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DJGastosMovilidadCollection;
use App\DJGastosMovilidad;

/**
 * @method static DJGastosMovilidadBuilder query()
 * @method static DJGastosMovilidadBuilder where(string $column,string $operator, string $value)
 * @method static DJGastosMovilidadBuilder where(string $column,string $value)
 * @method static DJGastosMovilidadBuilder whereNotNull(string $column)
 * @method static DJGastosMovilidadBuilder whereNull(string $column)
 * @method static DJGastosMovilidadBuilder whereIn(string $column,array $array)
 * @method static DJGastosMovilidadBuilder orderBy(string $column,array $sentido)
 * @method static DJGastosMovilidadBuilder select(array|string $columns)
 * @method static DJGastosMovilidadBuilder distinct()
 * @method static DJGastosMovilidadBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DJGastosMovilidadBuilder whereBetween(string $column, array $values)
 * @method static DJGastosMovilidadBuilder whereNotBetween(string $column, array $values)
 * @method static DJGastosMovilidadBuilder whereNotIn(string $column, array $values)
 * @method static DJGastosMovilidadBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DJGastosMovilidadBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DJGastosMovilidadBuilder whereYear(string $column, string $operator, int $value)
 * @method static DJGastosMovilidadBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DJGastosMovilidadBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DJGastosMovilidadBuilder groupBy(string ...$groups)
 * @method static DJGastosMovilidadBuilder limit(int $value)
 * @method static int count()
 * @method static DJGastosMovilidadCollection get(array|string $columns = ["*"])
 * @method static DJGastosMovilidad|null first()
 */
class DJGastosMovilidadBuilder extends Builder {}
