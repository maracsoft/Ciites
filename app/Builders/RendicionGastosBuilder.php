<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\RendicionGastosCollection;
use App\RendicionGastos;

/**
 * @method static RendicionGastosBuilder query()
 * @method static RendicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static RendicionGastosBuilder where(string $column,string $value)
 * @method static RendicionGastosBuilder whereNotNull(string $column)
 * @method static RendicionGastosBuilder whereNull(string $column)
 * @method static RendicionGastosBuilder whereIn(string $column,array $array)
 * @method static RendicionGastosBuilder orderBy(string $column,array $sentido)
 * @method static RendicionGastosBuilder select(array|string $columns)
 * @method static RendicionGastosBuilder distinct()
 * @method static RendicionGastosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static RendicionGastosBuilder whereBetween(string $column, array $values)
 * @method static RendicionGastosBuilder whereNotBetween(string $column, array $values)
 * @method static RendicionGastosBuilder whereNotIn(string $column, array $values)
 * @method static RendicionGastosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static RendicionGastosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static RendicionGastosBuilder whereYear(string $column, string $operator, int $value)
 * @method static RendicionGastosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static RendicionGastosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static RendicionGastosBuilder groupBy(string ...$groups)
 * @method static RendicionGastosBuilder limit(int $value)
 * @method static int count()
 * @method static RendicionGastosCollection get(array|string $columns = ["*"])
 * @method static RendicionGastos|null first()
 */
class RendicionGastosBuilder extends Builder {}
