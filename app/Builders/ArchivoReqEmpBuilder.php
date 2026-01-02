<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoReqEmpCollection;
use App\ArchivoReqEmp;

/**
 * @method static ArchivoReqEmpBuilder query()
 * @method static ArchivoReqEmpBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoReqEmpBuilder where(string $column,string $value)
 * @method static ArchivoReqEmpBuilder whereNotNull(string $column)
 * @method static ArchivoReqEmpBuilder whereNull(string $column)
 * @method static ArchivoReqEmpBuilder whereIn(string $column,array $array)
 * @method static ArchivoReqEmpBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoReqEmpBuilder select(array|string $columns)
 * @method static ArchivoReqEmpBuilder distinct()
 * @method static ArchivoReqEmpBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoReqEmpBuilder whereBetween(string $column, array $values)
 * @method static ArchivoReqEmpBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoReqEmpBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoReqEmpBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoReqEmpBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoReqEmpBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoReqEmpBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoReqEmpBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoReqEmpBuilder groupBy(string ...$groups)
 * @method static ArchivoReqEmpBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoReqEmpCollection get(array|string $columns = ["*"])
 * @method static ArchivoReqEmp|null first()
 */
class ArchivoReqEmpBuilder extends Builder {}
