<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\ScheduleUpdateResource;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{

    private function getSchedules(Request $request, $user)
    {
        $query = Schedule::orderBy('created_at', 'desc')
            ->with('customer', 'technician', 'parentSchedule');

        if ($search = $request->input('search')) {
            // Gabungkan pencarian customer_name dan problem dalam satu query
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($query) use ($search) {
                    $query->where('customer_name', 'like', '%' . $search . '%');
                })
                    ->orWhere('problem', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate(
            perPage: $request->input('limit', 30),
            page: $request->input('page', 1)
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $schedules = $this->getSchedules($request, $user);
        return ScheduleResource::collection($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request)
    {
        $data = $request->validated();
        // Map schedule_id to parent_schedule_id if present
        if (isset($data['schedule_id'])) {
            $data['parent_schedule_id'] = $data['schedule_id'];
            unset($data['schedule_id']);
        }
        $user = Auth::user();


        $schedule = new Schedule($data);
        $schedule->contact = $data['contact'];
        $schedule->customer_id = $data['customer'];
        $schedule->technician_id = $data['technician'] ?? null;
        $schedule->created_by = $user->id;
        $schedule->parent_schedule_id = $data['parent_schedule_id'] ?? null;
        $schedule->save();

        return new ScheduleResource($schedule);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $schedule = Schedule::where('uuid', $uuid)->firstOrFail();
        return new ScheduleUpdateResource($schedule);
    }

    public function history($id)
    {
        $schedules = Schedule::where('parent_schedule_id', $id)
            ->orWhere('id', $id)
            ->with('customer', 'technician', 'parentSchedule')
            ->orderBy('date', 'asc')
            ->get();

        return ScheduleResource::collection($schedules);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $uuid, ScheduleRequest $request)
    {
        $data = $request->validated();

        $schedule = Schedule::where('uuid', $uuid)->firstOrFail();
        $schedule->problem = $data['problem'];
        $schedule->contact = $data['contact'];
        $schedule->address = $data['address'];
        $schedule->customer_id = $data['customer'];
        $schedule->technician_id = $data['technician'];
        $schedule->save();

        $customer = $schedule->customer;
        $customer->customer_address = $data['address'];
        $customer->customer_phone = $data['contact'];
        $customer->save();

        return new ScheduleUpdateResource($schedule);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $schedule = Schedule::where('uuid', $uuid)->firstOrFail();
        $schedule->delete();
        return response()->json([
            "status" => true,
            "message" => "Schedule deleted successfully"
        ])->setStatusCode(200);
    }

    public function print(Request $request)
    {
        $date = $request['date'];
        $schedules = Schedule::where('date', $date)->with('customer', 'technician')->get();
        return ScheduleResource::collection($schedules);
    }

    public function empty(Request $request)
    {
        $schedules = Schedule::where('date', date('Y-m-d'))->where('technician_id', 0)->orWhere('technician_id', null)->get();
        return ScheduleResource::collection($schedules);
    }

    public function assign(Request $request)
    {
        try {
            $schedules = $request->all();

            DB::beginTransaction();

            foreach ($schedules as $schedule) {
                $scheduleModel = Schedule::where('uuid', $schedule['uuid'])->firstOrFail();
                $scheduleModel->technician_id = $schedule['technician'];
                $scheduleModel->save();
            }

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Schedules updated successfully"
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Gagal menyimpan data: " . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
