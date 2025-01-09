<?php

namespace App\Http\Controllers;

use App\Http\Resources\DashboardResource;
use App\Models\Dashboard;
use App\Models\Schedule;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }

    public function stats(Request $request)
    {
        $data = [
            'today' => Schedule::whereDate('date', Carbon::today())->count(),
            'technician' => Schedule::whereDate('date', Carbon::today())->distinct('technician_id')->count('technician_id'),
            'tommorow' => Schedule::whereDate('date', Carbon::tomorrow())->count(),
        ];

        return new DashboardResource($data);
    }
}
