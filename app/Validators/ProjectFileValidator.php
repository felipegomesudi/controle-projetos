<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 17:30
 */

namespace ControleProjetos\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'name'        => 'required',
            'file'        => 'required|mimes:jpeg,jpg,png,gif,pdf,zip',
            'description' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'        => 'required',
            'description' => 'required',
        ]


    ];
}