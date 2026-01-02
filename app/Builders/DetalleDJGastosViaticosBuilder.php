<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleDJGastosViaticosCollection;
use App\DetalleDJGastosViaticos;

/**
 * @method static DetalleDJGastosViaticosBuilder query()
 * @method static DetalleDJGastosViaticosBuilder where(string $column,string $operator, string $value)
 * @method static DetalleDJGastosViaticosBuilder where(string $column,string $value)
 * @method static DetalleDJGastosViaticosBuilder whereNotNull(string $column)
 * @method static DetalleDJGastosViaticosBuilder whereNull(string $column)
 * @method static DetalleDJGastosViaticosBuilder whereIn(string $column,array $array)
 * @method static DetalleDJGastosViaticosBuilder orderBy(string $column,array $sentido)
 * @method static DetalleDJGastosViaticosBuilder select(array|string $columns)
 * @method static DetalleDJGastosViaticosBuilder distinct()
 * @method static DetalleDJGastosViaticosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleDJGastosViaticosBuilder whereBetween(string $column, array $values)
 * @method static DetalleDJGastosViaticosBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleDJGastosViaticosBuilder whereNotIn(string $column, array $values)
 * @method static DetalleDJGastosViaticosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleDJGastosViaticosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleDJGastosViaticosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleDJGastosViaticosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleDJGastosViaticosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleDJGastosViaticosBuilder groupBy(string ...$groups)
 * @method static DetalleDJGastosViaticosBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleDJGastosViaticosCollection get(array|string $columns = ["*"])
 * @method static DetalleDJGastosViaticos|null first()
 */
class DetalleDJGastosViaticosBuilder extends Builder {}
