<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ProyectoCollection;
use App\Proyecto;

/**
 * @method static ProyectoBuilder query()
 * @method static ProyectoBuilder where(string $column,string $operator, string $value)
 * @method static ProyectoBuilder where(string $column,string $value)
 * @method static ProyectoBuilder whereNotNull(string $column)
 * @method static ProyectoBuilder whereNull(string $column)
 * @method static ProyectoBuilder whereIn(string $column,array $array)
 * @method static ProyectoBuilder orderBy(string $column,array $sentido)
 * @method static ProyectoBuilder select(array|string $columns)
 * @method static ProyectoBuilder distinct()
 * @method static ProyectoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ProyectoBuilder whereBetween(string $column, array $values)
 * @method static ProyectoBuilder whereNotBetween(string $column, array $values)
 * @method static ProyectoBuilder whereNotIn(string $column, array $values)
 * @method static ProyectoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ProyectoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ProyectoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ProyectoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ProyectoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ProyectoBuilder groupBy(string ...$groups)
 * @method static ProyectoBuilder limit(int $value)
 * @method static int count()
 * @method static ProyectoCollection get(array|string $columns = ["*"])
 * @method static Proyecto|null first()
 */
class ProyectoBuilder extends Builder {}
