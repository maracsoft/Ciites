<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleDJGastosVariosCollection;
use App\DetalleDJGastosVarios;

/**
 * @method static DetalleDJGastosVariosBuilder query()
 * @method static DetalleDJGastosVariosBuilder where(string $column,string $operator, string $value)
 * @method static DetalleDJGastosVariosBuilder where(string $column,string $value)
 * @method static DetalleDJGastosVariosBuilder whereNotNull(string $column)
 * @method static DetalleDJGastosVariosBuilder whereNull(string $column)
 * @method static DetalleDJGastosVariosBuilder whereIn(string $column,array $array)
 * @method static DetalleDJGastosVariosBuilder orderBy(string $column,array $sentido)
 * @method static DetalleDJGastosVariosBuilder select(array|string $columns)
 * @method static DetalleDJGastosVariosBuilder distinct()
 * @method static DetalleDJGastosVariosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleDJGastosVariosBuilder whereBetween(string $column, array $values)
 * @method static DetalleDJGastosVariosBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleDJGastosVariosBuilder whereNotIn(string $column, array $values)
 * @method static DetalleDJGastosVariosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleDJGastosVariosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleDJGastosVariosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleDJGastosVariosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleDJGastosVariosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleDJGastosVariosBuilder groupBy(string ...$groups)
 * @method static DetalleDJGastosVariosBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleDJGastosVariosCollection get(array|string $columns = ["*"])
 * @method static DetalleDJGastosVarios|null first()
 */
class DetalleDJGastosVariosBuilder extends Builder {}
