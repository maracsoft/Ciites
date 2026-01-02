<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ActividadResultadoCollection;
use App\ActividadResultado;

/**
 * @method static ActividadResultadoBuilder query()
 * @method static ActividadResultadoBuilder where(string $column,string $operator, string $value)
 * @method static ActividadResultadoBuilder where(string $column,string $value)
 * @method static ActividadResultadoBuilder whereNotNull(string $column)
 * @method static ActividadResultadoBuilder whereNull(string $column)
 * @method static ActividadResultadoBuilder whereIn(string $column,array $array)
 * @method static ActividadResultadoBuilder orderBy(string $column,array $sentido)
 * @method static ActividadResultadoBuilder select(array|string $columns)
 * @method static ActividadResultadoBuilder distinct()
 * @method static ActividadResultadoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ActividadResultadoBuilder whereBetween(string $column, array $values)
 * @method static ActividadResultadoBuilder whereNotBetween(string $column, array $values)
 * @method static ActividadResultadoBuilder whereNotIn(string $column, array $values)
 * @method static ActividadResultadoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ActividadResultadoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ActividadResultadoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ActividadResultadoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ActividadResultadoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ActividadResultadoBuilder groupBy(string ...$groups)
 * @method static ActividadResultadoBuilder limit(int $value)
 * @method static int count()
 * @method static ActividadResultadoCollection get(array|string $columns = ["*"])
 * @method static ActividadResultado|null first()
 */
class ActividadResultadoBuilder extends Builder {}
