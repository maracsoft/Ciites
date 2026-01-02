<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EstadoReposicionGastosCollection;
use App\EstadoReposicionGastos;

/**
 * @method static EstadoReposicionGastosBuilder query()
 * @method static EstadoReposicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static EstadoReposicionGastosBuilder where(string $column,string $value)
 * @method static EstadoReposicionGastosBuilder whereNotNull(string $column)
 * @method static EstadoReposicionGastosBuilder whereNull(string $column)
 * @method static EstadoReposicionGastosBuilder whereIn(string $column,array $array)
 * @method static EstadoReposicionGastosBuilder orderBy(string $column,array $sentido)
 * @method static EstadoReposicionGastosBuilder select(array|string $columns)
 * @method static EstadoReposicionGastosBuilder distinct()
 * @method static EstadoReposicionGastosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EstadoReposicionGastosBuilder whereBetween(string $column, array $values)
 * @method static EstadoReposicionGastosBuilder whereNotBetween(string $column, array $values)
 * @method static EstadoReposicionGastosBuilder whereNotIn(string $column, array $values)
 * @method static EstadoReposicionGastosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EstadoReposicionGastosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EstadoReposicionGastosBuilder whereYear(string $column, string $operator, int $value)
 * @method static EstadoReposicionGastosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EstadoReposicionGastosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EstadoReposicionGastosBuilder groupBy(string ...$groups)
 * @method static EstadoReposicionGastosBuilder limit(int $value)
 * @method static int count()
 * @method static EstadoReposicionGastosCollection get(array|string $columns = ["*"])
 * @method static EstadoReposicionGastos|null first()
 */
class EstadoReposicionGastosBuilder extends Builder {}
