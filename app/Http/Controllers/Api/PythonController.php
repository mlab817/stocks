<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class PythonController extends Controller
{
    public function getStockList()
    {
        return response()->json(Company::all());
    }
}
