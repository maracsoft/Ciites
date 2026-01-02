<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DJGastosViaticosCollection;
use App\DJGastosViaticos;

/**
 * @method static DJGastosViaticosBuilder query()
 * @method static DJGastosViaticosBuilder where(string $column,string $operator, string $value)
 * @method static DJGastosViaticosBuilder where(string $column,string $value)
 * @method static DJGastosViaticosBuilder whereNotNull(string $column)
 * @method static DJGastosViaticosBuilder whereNull(string $column)
 * @method static DJGastosViaticosBuilder whereIn(string $column,array $array)
 * @method static DJGastosViaticosBuilder orderBy(string $column,array $sentido)
 * @method static DJGastosViaticosBuilder select(array|string $columns)
 * @method static DJGastosViaticosBuilder distinct()
 * @method static DJGastosViaticosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DJGastosViaticosBuilder whereBetween(string $column, array $values)
 * @method static DJGastosViaticosBuilder whereNotBetween(string $column, array $values)
 * @method static DJGastosViaticosBuilder whereNotIn(string $column, array $values)
 * @method static DJGastosViaticosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DJGastosViaticosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DJGastosViaticosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DJGastosViaticosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DJGastosViaticosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DJGastosViaticosBuilder groupBy(string ...$groups)
 * @method static DJGastosViaticosBuilder limit(int $value)
 * @method static int count()
 * @method static DJGastosViaticosCollection get(array|string $columns = ["*"])
 * @method static DJGastosViaticos|null first()
 */
class DJGastosViaticosBuilder extends Builder {}
