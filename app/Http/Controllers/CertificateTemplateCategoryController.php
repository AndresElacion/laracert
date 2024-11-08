<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplateCategory;
use Illuminate\Http\Request;

class CertificateTemplateCategoryController extends Controller
{
    public function index()
    {
        $categories = CertificateTemplateCategory::orderBy('name')->get();
        
        return view('admin.certificate-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.certificate-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certificate_template_categories',
            'description' => 'nullable|string'
        ]);

        CertificateTemplateCategory::create($validated);

        return redirect()
            ->route('admin.certificate-categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(CertificateTemplateCategory $category)
    {
        return view('admin.certificate-categories.edit', compact('category'));
    }

    public function update(Request $request, CertificateTemplateCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certificate_template_categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.certificate-categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(CertificateTemplateCategory $category)
    {
        $category->delete();
        return redirect()
            ->route('admin.certificate-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}