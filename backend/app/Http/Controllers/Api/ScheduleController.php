<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function show(Schedule $schedule)
    {
        return $schedule;
    }

    public function save(Schedule $schedule)
    {
        $schedule->update(['status' => 'draft']);

        return response()->json([
            'message' => 'Сохранено',
            'schedule' => $schedule,
        ]);
    }

    public function publish(Schedule $schedule)
    {
        $schedule->update(['status' => 'published']);

        return response()->json([
            'message' => 'Опубликовано',
            'schedule' => $schedule,
        ]);
    }
}