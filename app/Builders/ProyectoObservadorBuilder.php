<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ProyectoObservadorCollection;
use App\ProyectoObservador;

/**
 * @method static ProyectoObservadorBuilder query()
 * @method static ProyectoObservadorBuilder where(string $column,string $operator, string $value)
 * @method static ProyectoObservadorBuilder where(string $column,string $value)
 * @method static ProyectoObservadorBuilder whereNotNull(string $column)
 * @method static ProyectoObservadorBuilder whereNull(string $column)
 * @method static ProyectoObservadorBuilder whereIn(string $column,array $array)
 * @method static ProyectoObservadorBuilder orderBy(string $column,array $sentido)
 * @method static ProyectoObservadorBuilder select(array|string $columns)
 * @method static ProyectoObservadorBuilder distinct()
 * @method static ProyectoObservadorBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ProyectoObservadorBuilder whereBetween(string $column, array $values)
 * @method static ProyectoObservadorBuilder whereNotBetween(string $column, array $values)
 * @method static ProyectoObservadorBuilder whereNotIn(string $column, array $values)
 * @method static ProyectoObservadorBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ProyectoObservadorBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ProyectoObservadorBuilder whereYear(string $column, string $operator, int $value)
 * @method static ProyectoObservadorBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ProyectoObservadorBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ProyectoObservadorBuilder groupBy(string ...$groups)
 * @method static ProyectoObservadorBuilder limit(int $value)
 * @method static int count()
 * @method static ProyectoObservadorCollection get(array|string $columns = ["*"])
 * @method static ProyectoObservador|null first()
 */
class ProyectoObservadorBuilder extends Builder {}
