<?php

namespace Modules\Tenants\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tenants\Models\Tenant;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::query()->get();

        return response()->json($tenants);
    }
}
