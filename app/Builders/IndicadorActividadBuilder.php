<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\IndicadorActividadCollection;
use App\IndicadorActividad;

/**
 * @method static IndicadorActividadBuilder query()
 * @method static IndicadorActividadBuilder where(string $column,string $operator, string $value)
 * @method static IndicadorActividadBuilder where(string $column,string $value)
 * @method static IndicadorActividadBuilder whereNotNull(string $column)
 * @method static IndicadorActividadBuilder whereNull(string $column)
 * @method static IndicadorActividadBuilder whereIn(string $column,array $array)
 * @method static IndicadorActividadBuilder orderBy(string $column,array $sentido)
 * @method static IndicadorActividadBuilder select(array|string $columns)
 * @method static IndicadorActividadBuilder distinct()
 * @method static IndicadorActividadBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static IndicadorActividadBuilder whereBetween(string $column, array $values)
 * @method static IndicadorActividadBuilder whereNotBetween(string $column, array $values)
 * @method static IndicadorActividadBuilder whereNotIn(string $column, array $values)
 * @method static IndicadorActividadBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static IndicadorActividadBuilder whereMonth(string $column, string $operator, int $value)
 * @method static IndicadorActividadBuilder whereYear(string $column, string $operator, int $value)
 * @method static IndicadorActividadBuilder whereColumn(string $first, string $operator, string $second)
 * @method static IndicadorActividadBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static IndicadorActividadBuilder groupBy(string ...$groups)
 * @method static IndicadorActividadBuilder limit(int $value)
 * @method static int count()
 * @method static IndicadorActividadCollection get(array|string $columns = ["*"])
 * @method static IndicadorActividad|null first()
 */
class IndicadorActividadBuilder extends Builder {}
