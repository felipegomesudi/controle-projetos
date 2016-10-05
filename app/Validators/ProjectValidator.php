<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 17:30
 */

namespace ControleProjetos\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
    protected $rules = [
        'owner_id' => 'required|integer',
        'client_id' => 'required|integer',
        'name' => 'required|email',
        'progress' => 'required',
        'status' => 'required',
        'due_date' => 'required'
    ];
}