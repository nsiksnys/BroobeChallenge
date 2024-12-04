<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MetricHistoryRunController extends Controller
{
    // Logger
    private $log;

    public function __construct(Logger $logger)
    {
        $this->log = $logger;
    }

    public function index(): View
    {
        $categories = Category::all();
        $strategies = Strategy::all();
        
        $object = new MetricHistoryRun();

        return view('metrics.index', [
            'categories' => $categories,
            'strategies' => $strategies,
            'fillables' => $object->getFillable()
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function list(): View
    {
        $records = MetricHistoryRun::all();
        return view('metrics.list', [
            'records' => $records
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), [
                'url' => 'bail|required|url:http,https|max:255',
                'accesibility_metric' => 'required|numeric',
                'pwa_metric' => 'required|numeric',
                'performance_metric' => 'required|numeric',
                'seo_metric' => 'required|numeric',
                'best_practices_metric' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $this->log->error("Validation failed for new MetricHistoryRun object.");

                return response()->json($validator->errors()->getMessages())->setStatusCode(400);
            }

            // Get the validated inputs.
            // This is better than calling one by one like before
            $validated = $validator->validated();

            $runRecord = new MetricHistoryRun($validated);
            $strategy = Strategy::find($request->input('strategy_id'));
            $strategy->metricHistoryRuns()->save($runRecord);

            $this->log->info("Stored new MetricHistoryRun object.");
            return response()->json("Metric saved");
        }
        catch (\Exception $e) {
            $this->log->error($e->getMessage());
            
            return response()->json("Something went wrong. Please try again later")->setStatusCode(500);
        }
    }
}
