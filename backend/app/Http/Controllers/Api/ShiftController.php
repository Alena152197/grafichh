<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request, Schedule $schedule)
    {
        $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        return $schedule->shifts()
            ->with(['employee', 'template'])
            ->whereBetween('date', [$request->from, $request->to])
            ->get();
    }

    public function store(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'date' => ['required', 'date'],
            'shift_template_id' => ['nullable', 'exists:shift_templates,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'duration_hours' => ['required', 'integer', 'min:1', 'max:24'],
        ]);

        $shift = $schedule->shifts()->updateOrCreate(
            [
                'employee_id' => $data['employee_id'],
                'date' => $data['date'],
            ],
            $data
        );

        return response()->json($shift->load(['employee', 'template']), 201);
    }

    public function update(Request $request, Shift $shift)
    {
        $data = $request->validate([
            'shift_template_id' => ['nullable', 'exists:shift_templates,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'duration_hours' => ['required', 'integer', 'min:1', 'max:24'],
        ]);

        $shift->update($data);

        return $shift->load(['employee', 'template']);
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        return response()->noContent();
    }

    public function bulkAssign(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'cells' => ['required', 'array', 'min:1'],
            'cells.*.employee_id' => ['required', 'exists:employees,id'],
            'cells.*.date' => ['required', 'date'],
            'shift_template_id' => ['nullable', 'exists:shift_templates,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'duration_hours' => ['required', 'integer', 'min:1', 'max:24'],
        ]);

        $result = [];

        foreach ($data['cells'] as $cell) {
            $result[] = $schedule->shifts()->updateOrCreate(
                [
                    'employee_id' => $cell['employee_id'],
                    'date' => $cell['date'],
                ],
                [
                    'shift_template_id' => $data['shift_template_id'] ?? null,
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'duration_hours' => $data['duration_hours'],
                ]
            )->load(['employee', 'template']);
        }

        return response()->json($result);
    }

    public function move(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'shift_id' => ['required', 'exists:shifts,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'date' => ['required', 'date'],
        ]);

        $shift = $schedule->shifts()->findOrFail($data['shift_id']);

        $schedule->shifts()
            ->where('employee_id', $data['employee_id'])
            ->whereDate('date', $data['date'])
            ->where('id', '!=', $shift->id)
            ->delete();

        $shift->update([
            'employee_id' => $data['employee_id'],
            'date' => $data['date'],
        ]);

        return $shift->fresh()->load(['employee', 'template']);
    }
}