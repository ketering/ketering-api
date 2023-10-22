<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('superadmin')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $types = Type::all();
        return view('meals.types.index', [
            'types' => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('meals.types.create');
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

        Type::create([
            'icon' => 'fas fa-bread-slice',
            ...$validator
        ]);
        return redirect()->route('types.index')->with('success', 'Tip uspješno kreiran');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
        return view('meals.types.show', [
            'type' => $type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
        return redirect()->route('types.show', $type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        //
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'max:255']
        ]);

        if ($validator->fails()) {
            return redirect(route('types.show', $type) . '#settings')->withErrors($validator->errors());
        }

        $type->update($validator->validated());
        return redirect()->route('types.index')->with('success', 'Tip uspješno ažuriran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $category = Type::findOrFail($id);
        try {
            $category->delete();
        } catch (\Exception $e) {
            return redirect()->route('types.index')->with('fail', 'Nije moguće obrisati tip');
        }
        return redirect()->route('types.index')->with('success', 'Tip uspješno obrisan');
    }
}
