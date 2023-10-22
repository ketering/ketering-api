<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->has('forDate')) {
            $orders = Order::where('forDate', '=', Carbon::parse($request->forDate));
        } else {
            $orders = Order::where('forDate', '=', today());
        }

        if ($request->has('status')) {
            $orders = $orders->where('status_id', '=', $request->status);
        } else {
            $orders = $orders->where('status_id', '=', 1);
        }

        $statuses = Status::all();
        return view('orders.index', [
            'orders' => $orders->get(),
            'statuses' => $statuses
        ]);
    }

    public function changeStatus(Request $request, Order $order)
    {
        # code
        $validator = \Validator::make($request->all(), [
            'status' => ['required', 'int']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $status = Status::findOrFail($request->status);
        $status->orders()->save($order);

        return back()->with('success', 'Status uspješno izmijenjen');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        $statuses = Status::all();
        return view('orders.show', [
            'order' => $order,
            'statuses' => $statuses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        return back();
    }
}
