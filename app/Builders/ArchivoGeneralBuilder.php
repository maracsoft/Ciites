<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoGeneralCollection;
use App\ArchivoGeneral;

/**
 * @method static ArchivoGeneralBuilder query()
 * @method static ArchivoGeneralBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoGeneralBuilder where(string $column,string $value)
 * @method static ArchivoGeneralBuilder whereNotNull(string $column)
 * @method static ArchivoGeneralBuilder whereNull(string $column)
 * @method static ArchivoGeneralBuilder whereIn(string $column,array $array)
 * @method static ArchivoGeneralBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoGeneralBuilder select(array|string $columns)
 * @method static ArchivoGeneralBuilder distinct()
 * @method static ArchivoGeneralBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoGeneralBuilder whereBetween(string $column, array $values)
 * @method static ArchivoGeneralBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoGeneralBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoGeneralBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoGeneralBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoGeneralBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoGeneralBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoGeneralBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoGeneralBuilder groupBy(string ...$groups)
 * @method static ArchivoGeneralBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoGeneralCollection get(array|string $columns = ["*"])
 * @method static ArchivoGeneral|null first()
 */
class ArchivoGeneralBuilder extends Builder {}
