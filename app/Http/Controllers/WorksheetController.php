<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Technician;
use App\Http\Resources\WorksheetCollection;

class WorksheetController extends Controller
{
    public function getWorksheets($date)
    {
        $worksheets = Technician::whereHas('schedules', function ($query) use ($date) {
            $query->whereDate('date', $date);
        })->with(['schedules' => function ($query) use ($date) {
            $query->whereDate('date', $date);
        }])->get();

        return new WorksheetCollection($worksheets, $date);
    }
}
