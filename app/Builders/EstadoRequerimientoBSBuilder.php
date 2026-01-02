<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\EstadoRequerimientoBSCollection;
use App\EstadoRequerimientoBS;

/**
 * @method static EstadoRequerimientoBSBuilder query()
 * @method static EstadoRequerimientoBSBuilder where(string $column,string $operator, string $value)
 * @method static EstadoRequerimientoBSBuilder where(string $column,string $value)
 * @method static EstadoRequerimientoBSBuilder whereNotNull(string $column)
 * @method static EstadoRequerimientoBSBuilder whereNull(string $column)
 * @method static EstadoRequerimientoBSBuilder whereIn(string $column,array $array)
 * @method static EstadoRequerimientoBSBuilder orderBy(string $column,array $sentido)
 * @method static EstadoRequerimientoBSBuilder select(array|string $columns)
 * @method static EstadoRequerimientoBSBuilder distinct()
 * @method static EstadoRequerimientoBSBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static EstadoRequerimientoBSBuilder whereBetween(string $column, array $values)
 * @method static EstadoRequerimientoBSBuilder whereNotBetween(string $column, array $values)
 * @method static EstadoRequerimientoBSBuilder whereNotIn(string $column, array $values)
 * @method static EstadoRequerimientoBSBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static EstadoRequerimientoBSBuilder whereMonth(string $column, string $operator, int $value)
 * @method static EstadoRequerimientoBSBuilder whereYear(string $column, string $operator, int $value)
 * @method static EstadoRequerimientoBSBuilder whereColumn(string $first, string $operator, string $second)
 * @method static EstadoRequerimientoBSBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static EstadoRequerimientoBSBuilder groupBy(string ...$groups)
 * @method static EstadoRequerimientoBSBuilder limit(int $value)
 * @method static int count()
 * @method static EstadoRequerimientoBSCollection get(array|string $columns = ["*"])
 * @method static EstadoRequerimientoBS|null first()
 */
class EstadoRequerimientoBSBuilder extends Builder {}
