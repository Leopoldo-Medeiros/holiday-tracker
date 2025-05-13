<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;
use App\Models\Engineer;
use Illuminate\Http\JsonResponse;

class GoogleCalendarTestController extends Controller
{
    protected $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Create a test engineer
     */
    public function createTestEngineer(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'calendar_id' => 'required|string'
        ]);

        $engineer = Engineer::create([
            'name' => $request->name,
            'email' => $request->email,
            'calendar_id' => $request->calendar_id,
            'team' => 'Test Team'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test engineer created successfully',
            'engineer' => $engineer
        ]);
    }

    /**
     * Test endpoint to sync holidays for a specific engineer
     */
    public function syncHolidays(int $engineerId): JsonResponse
    {
        try {
            $engineer = Engineer::findOrFail($engineerId);
            $this->calendarService->syncEngineerHolidays($engineer);

            return response()->json([
                'success' => true,
                'message' => "Successfully synced holidays for engineer {$engineer->name}",
                'engineer' => $engineer->load('holidays')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync holidays',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test endpoint to get all engineers with their holidays
     */
    public function getEngineersWithHolidays(): JsonResponse
    {
        $engineers = Engineer::with('holidays')->get();
        
        return response()->json([
            'success' => true,
            'data' => $engineers
        ]);
    }
}


