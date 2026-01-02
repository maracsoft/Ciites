<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoReposicionCollection;
use App\ArchivoReposicion;

/**
 * @method static ArchivoReposicionBuilder query()
 * @method static ArchivoReposicionBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoReposicionBuilder where(string $column,string $value)
 * @method static ArchivoReposicionBuilder whereNotNull(string $column)
 * @method static ArchivoReposicionBuilder whereNull(string $column)
 * @method static ArchivoReposicionBuilder whereIn(string $column,array $array)
 * @method static ArchivoReposicionBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoReposicionBuilder select(array|string $columns)
 * @method static ArchivoReposicionBuilder distinct()
 * @method static ArchivoReposicionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoReposicionBuilder whereBetween(string $column, array $values)
 * @method static ArchivoReposicionBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoReposicionBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoReposicionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoReposicionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoReposicionBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoReposicionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoReposicionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoReposicionBuilder groupBy(string ...$groups)
 * @method static ArchivoReposicionBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoReposicionCollection get(array|string $columns = ["*"])
 * @method static ArchivoReposicion|null first()
 */
class ArchivoReposicionBuilder extends Builder {}
