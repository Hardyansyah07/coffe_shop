<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeeklyRevenueReportController extends Controller
{
    public function index()
    {
        return view('admin.weekly_report');
    }
}
