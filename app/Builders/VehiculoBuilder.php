<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\VehiculoCollection;
use App\Vehiculo;

/**
 * @method static VehiculoBuilder query()
 * @method static VehiculoBuilder where(string $column,string $operator, string $value)
 * @method static VehiculoBuilder where(string $column,string $value)
 * @method static VehiculoBuilder whereNotNull(string $column)
 * @method static VehiculoBuilder whereNull(string $column)
 * @method static VehiculoBuilder whereIn(string $column,array $array)
 * @method static VehiculoBuilder orderBy(string $column,array $sentido)
 * @method static VehiculoBuilder select(array|string $columns)
 * @method static VehiculoBuilder distinct()
 * @method static VehiculoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static VehiculoBuilder whereBetween(string $column, array $values)
 * @method static VehiculoBuilder whereNotBetween(string $column, array $values)
 * @method static VehiculoBuilder whereNotIn(string $column, array $values)
 * @method static VehiculoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static VehiculoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static VehiculoBuilder whereYear(string $column, string $operator, int $value)
 * @method static VehiculoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static VehiculoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static VehiculoBuilder groupBy(string ...$groups)
 * @method static VehiculoBuilder limit(int $value)
 * @method static int count()
 * @method static VehiculoCollection get(array|string $columns = ["*"])
 * @method static Vehiculo|null first()
 */
class VehiculoBuilder extends Builder {}
