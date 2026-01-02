<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoReqAdminCollection;
use App\ArchivoReqAdmin;

/**
 * @method static ArchivoReqAdminBuilder query()
 * @method static ArchivoReqAdminBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoReqAdminBuilder where(string $column,string $value)
 * @method static ArchivoReqAdminBuilder whereNotNull(string $column)
 * @method static ArchivoReqAdminBuilder whereNull(string $column)
 * @method static ArchivoReqAdminBuilder whereIn(string $column,array $array)
 * @method static ArchivoReqAdminBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoReqAdminBuilder select(array|string $columns)
 * @method static ArchivoReqAdminBuilder distinct()
 * @method static ArchivoReqAdminBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoReqAdminBuilder whereBetween(string $column, array $values)
 * @method static ArchivoReqAdminBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoReqAdminBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoReqAdminBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoReqAdminBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoReqAdminBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoReqAdminBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoReqAdminBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoReqAdminBuilder groupBy(string ...$groups)
 * @method static ArchivoReqAdminBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoReqAdminCollection get(array|string $columns = ["*"])
 * @method static ArchivoReqAdmin|null first()
 */
class ArchivoReqAdminBuilder extends Builder {}
