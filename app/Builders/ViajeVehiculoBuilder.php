<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ViajeVehiculoCollection;
use App\ViajeVehiculo;

/**
 * @method static ViajeVehiculoBuilder query()
 * @method static ViajeVehiculoBuilder where(string $column,string $operator, string $value)
 * @method static ViajeVehiculoBuilder where(string $column,string $value)
 * @method static ViajeVehiculoBuilder whereNotNull(string $column)
 * @method static ViajeVehiculoBuilder whereNull(string $column)
 * @method static ViajeVehiculoBuilder whereIn(string $column,array $array)
 * @method static ViajeVehiculoBuilder orderBy(string $column,array $sentido)
 * @method static ViajeVehiculoBuilder select(array|string $columns)
 * @method static ViajeVehiculoBuilder distinct()
 * @method static ViajeVehiculoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ViajeVehiculoBuilder whereBetween(string $column, array $values)
 * @method static ViajeVehiculoBuilder whereNotBetween(string $column, array $values)
 * @method static ViajeVehiculoBuilder whereNotIn(string $column, array $values)
 * @method static ViajeVehiculoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ViajeVehiculoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ViajeVehiculoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ViajeVehiculoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ViajeVehiculoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ViajeVehiculoBuilder groupBy(string ...$groups)
 * @method static ViajeVehiculoBuilder limit(int $value)
 * @method static int count()
 * @method static ViajeVehiculoCollection get(array|string $columns = ["*"])
 * @method static ViajeVehiculo|null first()
 */
class ViajeVehiculoBuilder extends Builder {}
