<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EmpleadoRevisadorCollection;
use App\EmpleadoRevisador;

/**
 * @method static EmpleadoRevisadorBuilder query()
 * @method static EmpleadoRevisadorBuilder where(string $column,string $operator, string $value)
 * @method static EmpleadoRevisadorBuilder where(string $column,string $value)
 * @method static EmpleadoRevisadorBuilder whereNotNull(string $column)
 * @method static EmpleadoRevisadorBuilder whereNull(string $column)
 * @method static EmpleadoRevisadorBuilder whereIn(string $column,array $array)
 * @method static EmpleadoRevisadorBuilder orderBy(string $column,array $sentido)
 * @method static EmpleadoRevisadorBuilder select(array|string $columns)
 * @method static EmpleadoRevisadorBuilder distinct()
 * @method static EmpleadoRevisadorBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EmpleadoRevisadorBuilder whereBetween(string $column, array $values)
 * @method static EmpleadoRevisadorBuilder whereNotBetween(string $column, array $values)
 * @method static EmpleadoRevisadorBuilder whereNotIn(string $column, array $values)
 * @method static EmpleadoRevisadorBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EmpleadoRevisadorBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EmpleadoRevisadorBuilder whereYear(string $column, string $operator, int $value)
 * @method static EmpleadoRevisadorBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EmpleadoRevisadorBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EmpleadoRevisadorBuilder groupBy(string ...$groups)
 * @method static EmpleadoRevisadorBuilder limit(int $value)
 * @method static int count()
 * @method static EmpleadoRevisadorCollection get(array|string $columns = ["*"])
 * @method static EmpleadoRevisador|null first()
 */
class EmpleadoRevisadorBuilder extends Builder {}
