<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoProyectoCollection;
use App\ArchivoProyecto;

/**
 * @method static ArchivoProyectoBuilder query()
 * @method static ArchivoProyectoBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoProyectoBuilder where(string $column,string $value)
 * @method static ArchivoProyectoBuilder whereNotNull(string $column)
 * @method static ArchivoProyectoBuilder whereNull(string $column)
 * @method static ArchivoProyectoBuilder whereIn(string $column,array $array)
 * @method static ArchivoProyectoBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoProyectoBuilder select(array|string $columns)
 * @method static ArchivoProyectoBuilder distinct()
 * @method static ArchivoProyectoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoProyectoBuilder whereBetween(string $column, array $values)
 * @method static ArchivoProyectoBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoProyectoBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoProyectoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoProyectoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoProyectoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoProyectoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoProyectoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoProyectoBuilder groupBy(string ...$groups)
 * @method static ArchivoProyectoBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoProyectoCollection get(array|string $columns = ["*"])
 * @method static ArchivoProyecto|null first()
 */
class ArchivoProyectoBuilder extends Builder {}
