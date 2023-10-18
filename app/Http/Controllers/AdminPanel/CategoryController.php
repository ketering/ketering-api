<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('meals.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('meals.categories.create');
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

        Category::create([
            'icon' => 'fas fa-bread-slice',
            ...$validator
        ]);
        return redirect()->route('categories.index')->with('success', 'Category successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view('meals.categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return redirect()->route('categories.show', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'max:255']
        ]);

        if ($validator->fails()) {
            return redirect(route('categories.show', $category) . '#settings')->withErrors($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $category = Category::findOrFail($id);
        try {
            $category->delete();
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('fail', 'Nije moguće obrisati kategoriju');
        }
        return redirect()->route('categories.index')->with('success', 'Kategorija uspješno obrisana');
    }
}
