<?php

namespace VCComponent\Laravel\Order\Contracts;

use Illuminate\Http\Request;

interface ViewCartControllerInterface
{
    public function index(Request $request);
}
