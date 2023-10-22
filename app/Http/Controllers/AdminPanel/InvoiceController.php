<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        # code
        $companies = Company::all();
        return view('invoices.index', [
            'companies' => $companies
        ]);
    }

    public function generate(Request $request)
    {
        # code
        $company = Company::findOrFail($request->company_id);
        $dateFrom = substr($request->dateRange, 0, 10);
        $dateTo = substr($request->dateRange, 13, 23);

        $orders = Order::where('forDate', '>=', Carbon::parse($dateFrom))
            ->where('forDate', '<=', Carbon::parse($dateTo))->get()
            ->map(function ($order) use ($company) {
                if ($order->user->company == $company) {
                    return $order;
                }
            })->filter();

        if ($orders->isEmpty()) {
            return back()->with('fail', 'Nema narudžbina')->withInput($request->all());
        }

        $pdf = Pdf::loadView('invoices.export', [
            'orders' => $orders,
            'dateRange' => $request->dateRange
        ]);

        return $pdf->download('faktura' . trim($request->dateRange) . '.pdf');

        return view('invoices.export', [
            'orders' => $orders,
            'dateRange' => $request->dateRange
        ]);
    }
}
