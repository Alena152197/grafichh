<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShiftTemplate;

class ShiftTemplateController extends Controller
{
    public function index()
    {
        return ShiftTemplate::orderBy('id')->get();
    }
}
