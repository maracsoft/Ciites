<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EstadoRendicionGastosCollection;
use App\EstadoRendicionGastos;

/**
 * @method static EstadoRendicionGastosBuilder query()
 * @method static EstadoRendicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static EstadoRendicionGastosBuilder where(string $column,string $value)
 * @method static EstadoRendicionGastosBuilder whereNotNull(string $column)
 * @method static EstadoRendicionGastosBuilder whereNull(string $column)
 * @method static EstadoRendicionGastosBuilder whereIn(string $column,array $array)
 * @method static EstadoRendicionGastosBuilder orderBy(string $column,array $sentido)
 * @method static EstadoRendicionGastosBuilder select(array|string $columns)
 * @method static EstadoRendicionGastosBuilder distinct()
 * @method static EstadoRendicionGastosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EstadoRendicionGastosBuilder whereBetween(string $column, array $values)
 * @method static EstadoRendicionGastosBuilder whereNotBetween(string $column, array $values)
 * @method static EstadoRendicionGastosBuilder whereNotIn(string $column, array $values)
 * @method static EstadoRendicionGastosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EstadoRendicionGastosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EstadoRendicionGastosBuilder whereYear(string $column, string $operator, int $value)
 * @method static EstadoRendicionGastosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EstadoRendicionGastosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EstadoRendicionGastosBuilder groupBy(string ...$groups)
 * @method static EstadoRendicionGastosBuilder limit(int $value)
 * @method static int count()
 * @method static EstadoRendicionGastosCollection get(array|string $columns = ["*"])
 * @method static EstadoRendicionGastos|null first()
 */
class EstadoRendicionGastosBuilder extends Builder {}
