<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ProvinciaCollection;
use App\Provincia;

/**
 * @method static ProvinciaBuilder query()
 * @method static ProvinciaBuilder where(string $column,string $operator, string $value)
 * @method static ProvinciaBuilder where(string $column,string $value)
 * @method static ProvinciaBuilder whereNotNull(string $column)
 * @method static ProvinciaBuilder whereNull(string $column)
 * @method static ProvinciaBuilder whereIn(string $column,array $array)
 * @method static ProvinciaBuilder orderBy(string $column,array $sentido)
 * @method static ProvinciaBuilder select(array|string $columns)
 * @method static ProvinciaBuilder distinct()
 * @method static ProvinciaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ProvinciaBuilder whereBetween(string $column, array $values)
 * @method static ProvinciaBuilder whereNotBetween(string $column, array $values)
 * @method static ProvinciaBuilder whereNotIn(string $column, array $values)
 * @method static ProvinciaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ProvinciaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ProvinciaBuilder whereYear(string $column, string $operator, int $value)
 * @method static ProvinciaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ProvinciaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ProvinciaBuilder groupBy(string ...$groups)
 * @method static ProvinciaBuilder limit(int $value)
 * @method static int count()
 * @method static ProvinciaCollection get(array|string $columns = ["*"])
 * @method static Provincia|null first()
 */
class ProvinciaBuilder extends Builder {}
