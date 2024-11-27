<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'url' => 'bail|required|url:http,https|max:255',
            'accesibility_metric' => 'required|numeric',
            'pwa_metric' => 'required|numeric',
            'performance_metric' => 'required|numeric',
            'seo_metric' => 'required|numeric',
            'best_practices_metric' => 'required|numeric'
        ]);

        $runRecord = new MetricHistoryRun($validated);
        $strategy = Strategy::find($request->input('strategy_id'));
        $strategy->metricHistoryRuns()->save($runRecord);

        $this->log->info("Stored new MetricHistoryRun object.");
        return redirect(route('metrics_list'));
    }
}
