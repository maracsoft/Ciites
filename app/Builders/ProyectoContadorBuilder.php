<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ProyectoContadorCollection;
use App\ProyectoContador;

/**
 * @method static ProyectoContadorBuilder query()
 * @method static ProyectoContadorBuilder where(string $column,string $operator, string $value)
 * @method static ProyectoContadorBuilder where(string $column,string $value)
 * @method static ProyectoContadorBuilder whereNotNull(string $column)
 * @method static ProyectoContadorBuilder whereNull(string $column)
 * @method static ProyectoContadorBuilder whereIn(string $column,array $array)
 * @method static ProyectoContadorBuilder orderBy(string $column,array $sentido)
 * @method static ProyectoContadorBuilder select(array|string $columns)
 * @method static ProyectoContadorBuilder distinct()
 * @method static ProyectoContadorBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ProyectoContadorBuilder whereBetween(string $column, array $values)
 * @method static ProyectoContadorBuilder whereNotBetween(string $column, array $values)
 * @method static ProyectoContadorBuilder whereNotIn(string $column, array $values)
 * @method static ProyectoContadorBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ProyectoContadorBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ProyectoContadorBuilder whereYear(string $column, string $operator, int $value)
 * @method static ProyectoContadorBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ProyectoContadorBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ProyectoContadorBuilder groupBy(string ...$groups)
 * @method static ProyectoContadorBuilder limit(int $value)
 * @method static int count()
 * @method static ProyectoContadorCollection get(array|string $columns = ["*"])
 * @method static ProyectoContador|null first()
 */
class ProyectoContadorBuilder extends Builder {}
