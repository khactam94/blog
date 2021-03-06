<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Charts;

class StatisticController extends Controller
{
    public function index()
    {
        $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
            ->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
            ->title("Monthly new Register Users")
            ->elementLabel("Total Users")
            ->dimensions(1000, 500)
            ->responsive(false)
            ->groupByMonth(date('Y'), true);
        return view('admin.statistics.index',compact('chart'));
    }
}
