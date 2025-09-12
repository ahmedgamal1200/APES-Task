<?php

namespace Modules\TeamAvailability\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teamavailability::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teamavailability::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('teamavailability::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('teamavailability::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
