<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected function requireAdmin(): ?RedirectResponse
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login');
        }

        return null;
    }
}
