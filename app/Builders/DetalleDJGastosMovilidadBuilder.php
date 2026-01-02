<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleDJGastosMovilidadCollection;
use App\DetalleDJGastosMovilidad;

/**
 * @method static DetalleDJGastosMovilidadBuilder query()
 * @method static DetalleDJGastosMovilidadBuilder where(string $column,string $operator, string $value)
 * @method static DetalleDJGastosMovilidadBuilder where(string $column,string $value)
 * @method static DetalleDJGastosMovilidadBuilder whereNotNull(string $column)
 * @method static DetalleDJGastosMovilidadBuilder whereNull(string $column)
 * @method static DetalleDJGastosMovilidadBuilder whereIn(string $column,array $array)
 * @method static DetalleDJGastosMovilidadBuilder orderBy(string $column,array $sentido)
 * @method static DetalleDJGastosMovilidadBuilder select(array|string $columns)
 * @method static DetalleDJGastosMovilidadBuilder distinct()
 * @method static DetalleDJGastosMovilidadBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleDJGastosMovilidadBuilder whereBetween(string $column, array $values)
 * @method static DetalleDJGastosMovilidadBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleDJGastosMovilidadBuilder whereNotIn(string $column, array $values)
 * @method static DetalleDJGastosMovilidadBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleDJGastosMovilidadBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleDJGastosMovilidadBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleDJGastosMovilidadBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleDJGastosMovilidadBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleDJGastosMovilidadBuilder groupBy(string ...$groups)
 * @method static DetalleDJGastosMovilidadBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleDJGastosMovilidadCollection get(array|string $columns = ["*"])
 * @method static DetalleDJGastosMovilidad|null first()
 */
class DetalleDJGastosMovilidadBuilder extends Builder {}
