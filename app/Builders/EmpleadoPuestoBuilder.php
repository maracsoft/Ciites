<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EmpleadoPuestoCollection;
use App\EmpleadoPuesto;

/**
 * @method static EmpleadoPuestoBuilder query()
 * @method static EmpleadoPuestoBuilder where(string $column,string $operator, string $value)
 * @method static EmpleadoPuestoBuilder where(string $column,string $value)
 * @method static EmpleadoPuestoBuilder whereNotNull(string $column)
 * @method static EmpleadoPuestoBuilder whereNull(string $column)
 * @method static EmpleadoPuestoBuilder whereIn(string $column,array $array)
 * @method static EmpleadoPuestoBuilder orderBy(string $column,array $sentido)
 * @method static EmpleadoPuestoBuilder select(array|string $columns)
 * @method static EmpleadoPuestoBuilder distinct()
 * @method static EmpleadoPuestoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EmpleadoPuestoBuilder whereBetween(string $column, array $values)
 * @method static EmpleadoPuestoBuilder whereNotBetween(string $column, array $values)
 * @method static EmpleadoPuestoBuilder whereNotIn(string $column, array $values)
 * @method static EmpleadoPuestoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EmpleadoPuestoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EmpleadoPuestoBuilder whereYear(string $column, string $operator, int $value)
 * @method static EmpleadoPuestoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EmpleadoPuestoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EmpleadoPuestoBuilder groupBy(string ...$groups)
 * @method static EmpleadoPuestoBuilder limit(int $value)
 * @method static int count()
 * @method static EmpleadoPuestoCollection get(array|string $columns = ["*"])
 * @method static EmpleadoPuesto|null first()
 */
class EmpleadoPuestoBuilder extends Builder {}
