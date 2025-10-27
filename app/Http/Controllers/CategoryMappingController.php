<?php

namespace App\Http\Controllers;

use App\Models\CategoryMapping;
use Illuminate\Http\Request;

class CategoryMappingController extends Controller
{
    public function index()
    {
        $mappings = CategoryMapping::orderBy('product_category')->get();
        return view('admin.category_mapping.index', compact('mappings'));
    }

    public function create()
    {
        return view('admin.category_mapping.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category' => 'required|unique:category_mappings,product_category',
            'field_category' => 'required',
        ]);

        CategoryMapping::create($request->all());

        return redirect()->route('category-mapping.index')->with('success', 'Mapping added successfully.');
    }

    public function edit($id)
    {
        $mapping = CategoryMapping::findOrFail($id);
        return view('admin.category_mapping.edit', compact('mapping'));
    }

    public function update(Request $request, $id)
    {
        $mapping = CategoryMapping::findOrFail($id);

        $request->validate([
            'product_category' => 'required|unique:category_mappings,product_category,' . $id,
            'field_category' => 'required',
        ]);

        $mapping->update($request->all());

        return redirect()->route('category-mapping.index')->with('success', 'Mapping updated successfully.');
    }

    public function destroy($id)
    {
        CategoryMapping::findOrFail($id)->delete();
        return redirect()->route('category-mapping.index')->with('success', 'Mapping deleted successfully.');
    }
}

