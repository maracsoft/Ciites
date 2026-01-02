<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleSolicitudFondosCollection;
use App\DetalleSolicitudFondos;

/**
 * @method static DetalleSolicitudFondosBuilder query()
 * @method static DetalleSolicitudFondosBuilder where(string $column,string $operator, string $value)
 * @method static DetalleSolicitudFondosBuilder where(string $column,string $value)
 * @method static DetalleSolicitudFondosBuilder whereNotNull(string $column)
 * @method static DetalleSolicitudFondosBuilder whereNull(string $column)
 * @method static DetalleSolicitudFondosBuilder whereIn(string $column,array $array)
 * @method static DetalleSolicitudFondosBuilder orderBy(string $column,array $sentido)
 * @method static DetalleSolicitudFondosBuilder select(array|string $columns)
 * @method static DetalleSolicitudFondosBuilder distinct()
 * @method static DetalleSolicitudFondosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleSolicitudFondosBuilder whereBetween(string $column, array $values)
 * @method static DetalleSolicitudFondosBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleSolicitudFondosBuilder whereNotIn(string $column, array $values)
 * @method static DetalleSolicitudFondosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleSolicitudFondosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleSolicitudFondosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleSolicitudFondosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleSolicitudFondosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleSolicitudFondosBuilder groupBy(string ...$groups)
 * @method static DetalleSolicitudFondosBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleSolicitudFondosCollection get(array|string $columns = ["*"])
 * @method static DetalleSolicitudFondos|null first()
 */
class DetalleSolicitudFondosBuilder extends Builder {}
