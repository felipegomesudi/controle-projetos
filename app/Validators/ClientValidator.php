<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 17:30
 */

namespace ControleProjetos\Validators;


use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
    protected $rules = [
        'name' => 'required|max:255',
        'responsible' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required'
    ];
}