<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class FrontAdController extends Controller
{
    public function manage() {
        $orders = Order::with('category')->get(); // Lấy tất cả order kèm theo thông tin category
        return view('admin.order', compact('orders'));
    }
    public function index()
{
    $users = User::where('role', 1)->get();
    return view('admin.user', ['users' => $users]);
}
public function filterStats(Request $request)
{
    $year = $request->input('year');
    $month = $request->input('month');
    $viewType = $request->input('view_type'); // 'day', 'month', hoặc 'year'

    if ($viewType === 'day') {
        // Doanh thu theo ngày
        $dailyRevenue = Order::select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(total) as revenue'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('revenue', 'day');

        return response()->json($dailyRevenue);

    } elseif ($viewType === 'month') {
        // Doanh thu theo tháng
        $monthlyRevenue = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as revenue'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        return response()->json($monthlyRevenue);

    } else {
        // Doanh thu theo năm
        $yearlyRevenue = Order::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total) as revenue'))
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('revenue', 'year');

        return response()->json($yearlyRevenue);
    }
}

public function stats()
{
    // Tổng doanh thu từ bảng `orders`
    $totalRevenue = Order::sum('total');

    // Tổng chi phí từ bảng `import`
    $totalCost = Import::sum('total_price');

    // Lợi nhuận
    $profit = $totalRevenue - $totalCost;

    // 5 sản phẩm bán chạy nhất
    $topProducts = Order::select('category_id', DB::raw('SUM(quantity) as total_quantity'))
        ->with('category')
        ->groupBy('category_id')
        ->orderByDesc('total_quantity')
        ->take(5)
        ->get();

    return view('admin.dashboard', compact('totalRevenue', 'totalCost', 'profit', 'topProducts'));
}



}
