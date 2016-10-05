<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 04/10/2016
 * Time: 11:32
 */

namespace ControleProjetos\OAuth;

use Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}