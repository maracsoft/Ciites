<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoDocumentoCollection;
use App\TipoDocumento;

/**
 * @method static TipoDocumentoBuilder query()
 * @method static TipoDocumentoBuilder where(string $column,string $operator, string $value)
 * @method static TipoDocumentoBuilder where(string $column,string $value)
 * @method static TipoDocumentoBuilder whereNotNull(string $column)
 * @method static TipoDocumentoBuilder whereNull(string $column)
 * @method static TipoDocumentoBuilder whereIn(string $column,array $array)
 * @method static TipoDocumentoBuilder orderBy(string $column,array $sentido)
 * @method static TipoDocumentoBuilder select(array|string $columns)
 * @method static TipoDocumentoBuilder distinct()
 * @method static TipoDocumentoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoDocumentoBuilder whereBetween(string $column, array $values)
 * @method static TipoDocumentoBuilder whereNotBetween(string $column, array $values)
 * @method static TipoDocumentoBuilder whereNotIn(string $column, array $values)
 * @method static TipoDocumentoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoDocumentoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoDocumentoBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoDocumentoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoDocumentoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoDocumentoBuilder groupBy(string ...$groups)
 * @method static TipoDocumentoBuilder limit(int $value)
 * @method static int count()
 * @method static TipoDocumentoCollection get(array|string $columns = ["*"])
 * @method static TipoDocumento|null first()
 */
class TipoDocumentoBuilder extends Builder {}
