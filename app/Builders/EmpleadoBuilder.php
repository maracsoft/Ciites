<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EmpleadoCollection;
use App\Empleado;

/**
 * @method static EmpleadoBuilder query()
 * @method static EmpleadoBuilder where(string $column,string $operator, string $value)
 * @method static EmpleadoBuilder where(string $column,string $value)
 * @method static EmpleadoBuilder whereNotNull(string $column)
 * @method static EmpleadoBuilder whereNull(string $column)
 * @method static EmpleadoBuilder whereIn(string $column,array $array)
 * @method static EmpleadoBuilder orderBy(string $column,array $sentido)
 * @method static EmpleadoBuilder select(array|string $columns)
 * @method static EmpleadoBuilder distinct()
 * @method static EmpleadoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EmpleadoBuilder whereBetween(string $column, array $values)
 * @method static EmpleadoBuilder whereNotBetween(string $column, array $values)
 * @method static EmpleadoBuilder whereNotIn(string $column, array $values)
 * @method static EmpleadoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EmpleadoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EmpleadoBuilder whereYear(string $column, string $operator, int $value)
 * @method static EmpleadoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EmpleadoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EmpleadoBuilder groupBy(string ...$groups)
 * @method static EmpleadoBuilder limit(int $value)
 * @method static int count()
 * @method static EmpleadoCollection get(array|string $columns = ["*"])
 * @method static Empleado|null first()
 */
class EmpleadoBuilder extends Builder {}
