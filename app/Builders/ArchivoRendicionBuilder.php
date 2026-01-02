<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoRendicionCollection;
use App\ArchivoRendicion;

/**
 * @method static ArchivoRendicionBuilder query()
 * @method static ArchivoRendicionBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoRendicionBuilder where(string $column,string $value)
 * @method static ArchivoRendicionBuilder whereNotNull(string $column)
 * @method static ArchivoRendicionBuilder whereNull(string $column)
 * @method static ArchivoRendicionBuilder whereIn(string $column,array $array)
 * @method static ArchivoRendicionBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoRendicionBuilder select(array|string $columns)
 * @method static ArchivoRendicionBuilder distinct()
 * @method static ArchivoRendicionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoRendicionBuilder whereBetween(string $column, array $values)
 * @method static ArchivoRendicionBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoRendicionBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoRendicionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoRendicionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoRendicionBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoRendicionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoRendicionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoRendicionBuilder groupBy(string ...$groups)
 * @method static ArchivoRendicionBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoRendicionCollection get(array|string $columns = ["*"])
 * @method static ArchivoRendicion|null first()
 */
class ArchivoRendicionBuilder extends Builder {}
