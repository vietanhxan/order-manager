<?php

namespace VCComponent\Laravel\Order\Contracts;

use Illuminate\Http\Request;

interface ViewOrderControllerInterface
{
    public function index(Request $request);
}
