<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ReposicionGastosCollection;
use App\ReposicionGastos;

/**
 * @method static ReposicionGastosBuilder query()
 * @method static ReposicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static ReposicionGastosBuilder where(string $column,string $value)
 * @method static ReposicionGastosBuilder whereNotNull(string $column)
 * @method static ReposicionGastosBuilder whereNull(string $column)
 * @method static ReposicionGastosBuilder whereIn(string $column,array $array)
 * @method static ReposicionGastosBuilder orderBy(string $column,array $sentido)
 * @method static ReposicionGastosBuilder select(array|string $columns)
 * @method static ReposicionGastosBuilder distinct()
 * @method static ReposicionGastosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ReposicionGastosBuilder whereBetween(string $column, array $values)
 * @method static ReposicionGastosBuilder whereNotBetween(string $column, array $values)
 * @method static ReposicionGastosBuilder whereNotIn(string $column, array $values)
 * @method static ReposicionGastosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ReposicionGastosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ReposicionGastosBuilder whereYear(string $column, string $operator, int $value)
 * @method static ReposicionGastosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ReposicionGastosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ReposicionGastosBuilder groupBy(string ...$groups)
 * @method static ReposicionGastosBuilder limit(int $value)
 * @method static int count()
 * @method static ReposicionGastosCollection get(array|string $columns = ["*"])
 * @method static ReposicionGastos|null first()
 */
class ReposicionGastosBuilder extends Builder {}
