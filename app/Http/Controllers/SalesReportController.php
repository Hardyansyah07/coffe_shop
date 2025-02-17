<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesReport;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index()
    {
        $reports = SalesReport::with('category')->get();
        return view('admin.sales_reports.index', compact('reports'));
    }

    public function generateReport()
    {
        $date = Carbon::now()->toDateString();

        // Ambil data penjualan berdasarkan kategori menu
        $salesData = OrderItem::join('menus', 'order_items.nama', '=', 'menus.nama')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->select(
                'categories.id as category_id',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->whereDate('order_items.created_at', $date)
            ->groupBy('categories.id')
            ->get();

        foreach ($salesData as $data) {
            SalesReport::updateOrCreate(
                ['category_id' => $data->category_id, 'date' => $date],
                ['total_sold' => $data->total_sold, 'total_revenue' => $data->total_revenue]
            );
        }

        return redirect()->route('admin.sales_reports.index')->with('success', 'Laporan penjualan berhasil dibuat!');
    }
}
