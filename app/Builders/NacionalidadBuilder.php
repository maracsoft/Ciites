<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\NacionalidadCollection;
use App\Nacionalidad;

/**
 * @method static NacionalidadBuilder query()
 * @method static NacionalidadBuilder where(string $column,string $operator, string $value)
 * @method static NacionalidadBuilder where(string $column,string $value)
 * @method static NacionalidadBuilder whereNotNull(string $column)
 * @method static NacionalidadBuilder whereNull(string $column)
 * @method static NacionalidadBuilder whereIn(string $column,array $array)
 * @method static NacionalidadBuilder orderBy(string $column,array $sentido)
 * @method static NacionalidadBuilder select(array|string $columns)
 * @method static NacionalidadBuilder distinct()
 * @method static NacionalidadBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static NacionalidadBuilder whereBetween(string $column, array $values)
 * @method static NacionalidadBuilder whereNotBetween(string $column, array $values)
 * @method static NacionalidadBuilder whereNotIn(string $column, array $values)
 * @method static NacionalidadBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static NacionalidadBuilder whereMonth(string $column, string $operator, int $value)
 * @method static NacionalidadBuilder whereYear(string $column, string $operator, int $value)
 * @method static NacionalidadBuilder whereColumn(string $first, string $operator, string $second)
 * @method static NacionalidadBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static NacionalidadBuilder groupBy(string ...$groups)
 * @method static NacionalidadBuilder limit(int $value)
 * @method static int count()
 * @method static NacionalidadCollection get(array|string $columns = ["*"])
 * @method static Nacionalidad|null first()
 */
class NacionalidadBuilder extends Builder {}
