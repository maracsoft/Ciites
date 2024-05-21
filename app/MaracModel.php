<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use ArrayAccess;
use Illuminate\Contracts\Queue\QueueableCollection;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonSerializable;

class MaracModel extends Model implements Arrayable, ArrayAccess, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
 
    
    /* ESTO LO ESTOY AÑADIENDO YOOOO XD */
    public function getID(){
      return $this[$this->getKeyName()];
    }

    public function isThisSelected($id){
      if($id == $this->getId())
        return "selected";
      return "";
    }
    public function existe(): bool
    {
      return $this->getId() != null;
    }
}
