<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $statuses = Status::all();
        return view('orders.statuses.index', [
            'statuses' => $statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('orders.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'max:255']
        ])->validate();

        Status::create([
            'icon' => 'fas fa-signal',
            ...$validator
        ]);
        return redirect()->route('statuses.index')->with('success', 'Status successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
        return view('orders.statuses.show', [
            'status' => $status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
        return redirect()->route('statuses.show', $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'max:255']
        ]);

        if ($validator->fails()) {
            return redirect(route('statuses.show', $status) . '#settings')->withErrors($validator->errors());
        }

        $status->update($validator->validated());
        return redirect()->route('statuses.index')->with('success', 'Status successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $status = Status::findOrFail($id);
        try {
            $status->delete();
        } catch (\Exception $e) {
            return redirect()->route('statuses.index')->with('fail', 'Nije moguće obrisati status');
        }
        return redirect()->route('statuses.index')->with('success', 'Status uspješno obrisan');
    }
}
