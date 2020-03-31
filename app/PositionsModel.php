<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionsModel extends Model
{

    /** 
     * The table associated with the model
     * @var string
     */

    protected $table = 'positions';

    /**
     * Primary key associated with the model
     * @var integer
     */

    protected $primaryKey = 'position_id';

    /**
     * The attributes that are mass assignable
     * @var array
     */

    protected $fillable  = [
        'position_name'
    ];
    /**
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at',
        'position_id'
    ];
}
