<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    /**
     * The table associated with the model
     * @var string
     */

    protected $table = 'employees';


    /**
     * The primary key associated with the table
     * @var integer
     */

    protected $primaryKey = 'employee_id';

    /**
     * @var array
     */
    
    protected $fillable = [
        'position_key',
        'name',
        'email',
        'age',
        'cpf',
        'last_name',
        'image'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'employees_id'
    ];
}
