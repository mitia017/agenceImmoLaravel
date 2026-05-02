<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Models\Sale;
use App\Http\Resources\DashboardResource;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return new DashboardResource($request->user());
    }
}