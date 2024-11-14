<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificateTemplateCategory;

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
        // Validate request inputs including the file
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certificate_template_categories',
            'description' => 'nullable|string',
            'certificate_template' => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        // Check if a file has been uploaded
        if ($request->hasFile('certificate_template') && $request->file('certificate_template')->isValid()) {
            // Store the image in the 'public/certificates' directory
            $path = $request->file('certificate_template')->store('certificates', 'public');
            $validated['certificate_template'] = $path;
        }

        // Create the category with the validated data
        CertificateTemplateCategory::create($validated);

        // Redirect back with a success message
        return redirect()
            ->route('admin.certificate-categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(CertificateTemplateCategory $certificate_category)
    {
        return view('admin.certificate-categories.edit', compact('certificate_category'));
    }

    public function update(Request $request, CertificateTemplateCategory $certificate_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certificate_template_categories,name,' . $certificate_category->id,
            'description' => 'nullable|string',
            'certificate_template' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('certificate_template') && $request->file('certificate_template')->isValid()) {
            // Delete the old file if it exists
            if ($certificate_category->certificate_template) {
                Storage::disk('public')->delete($certificate_category->certificate_template);
            }
            
            // Store the new image file
            $path = $request->file('certificate_template')->store('certificates', 'public');
            $validated['certificate_template'] = $path;
        }

        // Update the category record
        $certificate_category->update($validated);

        return redirect()
            ->route('admin.certificate-categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(CertificateTemplateCategory $certificate_category)
    {
        $certificate_category->delete();
        return redirect()
            ->route('admin.certificate-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}