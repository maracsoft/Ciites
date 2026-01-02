<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\OperacionDocumentoCollection;
use App\OperacionDocumento;

/**
 * @method static OperacionDocumentoBuilder query()
 * @method static OperacionDocumentoBuilder where(string $column,string $operator, string $value)
 * @method static OperacionDocumentoBuilder where(string $column,string $value)
 * @method static OperacionDocumentoBuilder whereNotNull(string $column)
 * @method static OperacionDocumentoBuilder whereNull(string $column)
 * @method static OperacionDocumentoBuilder whereIn(string $column,array $array)
 * @method static OperacionDocumentoBuilder orderBy(string $column,array $sentido)
 * @method static OperacionDocumentoBuilder select(array|string $columns)
 * @method static OperacionDocumentoBuilder distinct()
 * @method static OperacionDocumentoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static OperacionDocumentoBuilder whereBetween(string $column, array $values)
 * @method static OperacionDocumentoBuilder whereNotBetween(string $column, array $values)
 * @method static OperacionDocumentoBuilder whereNotIn(string $column, array $values)
 * @method static OperacionDocumentoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static OperacionDocumentoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static OperacionDocumentoBuilder whereYear(string $column, string $operator, int $value)
 * @method static OperacionDocumentoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static OperacionDocumentoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static OperacionDocumentoBuilder groupBy(string ...$groups)
 * @method static OperacionDocumentoBuilder limit(int $value)
 * @method static int count()
 * @method static OperacionDocumentoCollection get(array|string $columns = ["*"])
 * @method static OperacionDocumento|null first()
 */
class OperacionDocumentoBuilder extends Builder {}
