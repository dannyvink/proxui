<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Proxmark3;

class History extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['cloneable'];

    /**
     * Convert the current history entry into a tag instance.
     * @return Tag
     */
    public function toTag() {
        return Proxmark3::tagFromIdentifier($this->type, $this->identifier);
    }

    /**
     * Returns true if this entry is cloneable, false otherwise.
     * @return boolean
     */
    public function getCloneableAttribute() {
        return $this->toTag()->cloneable;
    }

}
