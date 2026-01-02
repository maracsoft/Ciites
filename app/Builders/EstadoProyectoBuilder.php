<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EstadoProyectoCollection;
use App\EstadoProyecto;

/**
 * @method static EstadoProyectoBuilder query()
 * @method static EstadoProyectoBuilder where(string $column,string $operator, string $value)
 * @method static EstadoProyectoBuilder where(string $column,string $value)
 * @method static EstadoProyectoBuilder whereNotNull(string $column)
 * @method static EstadoProyectoBuilder whereNull(string $column)
 * @method static EstadoProyectoBuilder whereIn(string $column,array $array)
 * @method static EstadoProyectoBuilder orderBy(string $column,array $sentido)
 * @method static EstadoProyectoBuilder select(array|string $columns)
 * @method static EstadoProyectoBuilder distinct()
 * @method static EstadoProyectoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EstadoProyectoBuilder whereBetween(string $column, array $values)
 * @method static EstadoProyectoBuilder whereNotBetween(string $column, array $values)
 * @method static EstadoProyectoBuilder whereNotIn(string $column, array $values)
 * @method static EstadoProyectoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EstadoProyectoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EstadoProyectoBuilder whereYear(string $column, string $operator, int $value)
 * @method static EstadoProyectoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EstadoProyectoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EstadoProyectoBuilder groupBy(string ...$groups)
 * @method static EstadoProyectoBuilder limit(int $value)
 * @method static int count()
 * @method static EstadoProyectoCollection get(array|string $columns = ["*"])
 * @method static EstadoProyecto|null first()
 */
class EstadoProyectoBuilder extends Builder {}
