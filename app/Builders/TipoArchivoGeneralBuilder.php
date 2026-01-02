<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoArchivoGeneralCollection;
use App\TipoArchivoGeneral;

/**
 * @method static TipoArchivoGeneralBuilder query()
 * @method static TipoArchivoGeneralBuilder where(string $column,string $operator, string $value)
 * @method static TipoArchivoGeneralBuilder where(string $column,string $value)
 * @method static TipoArchivoGeneralBuilder whereNotNull(string $column)
 * @method static TipoArchivoGeneralBuilder whereNull(string $column)
 * @method static TipoArchivoGeneralBuilder whereIn(string $column,array $array)
 * @method static TipoArchivoGeneralBuilder orderBy(string $column,array $sentido)
 * @method static TipoArchivoGeneralBuilder select(array|string $columns)
 * @method static TipoArchivoGeneralBuilder distinct()
 * @method static TipoArchivoGeneralBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoArchivoGeneralBuilder whereBetween(string $column, array $values)
 * @method static TipoArchivoGeneralBuilder whereNotBetween(string $column, array $values)
 * @method static TipoArchivoGeneralBuilder whereNotIn(string $column, array $values)
 * @method static TipoArchivoGeneralBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoArchivoGeneralBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoArchivoGeneralBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoArchivoGeneralBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoArchivoGeneralBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoArchivoGeneralBuilder groupBy(string ...$groups)
 * @method static TipoArchivoGeneralBuilder limit(int $value)
 * @method static int count()
 * @method static TipoArchivoGeneralCollection get(array|string $columns = ["*"])
 * @method static TipoArchivoGeneral|null first()
 */
class TipoArchivoGeneralBuilder extends Builder {}
