<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MetricHistoryRunController extends Controller
{
    public function index() : View
    {
        $categories = Category::all();
        $strategies = Strategy::all();

        return view('metrics.index', [
            'categories' => $categories,
            'strategies' => $strategies
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function list() : View{
        $records = MetricHistoryRun::all();
        return view('metrics.list', [
            'records' => $records
        ]);
    }
}
