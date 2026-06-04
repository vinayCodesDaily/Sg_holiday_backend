<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    // =========================
    // ADMIN: LIST ALL PAGES
    // =========================
    public function index()
    {
        return CmsPage::latest()->get();
    }

    // =========================
    // ADMIN: CREATE PAGE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $page = CmsPage::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'status' => $request->status ?? 1,
        ]);

        return response()->json($page);
    }

    // =========================
    // ADMIN: SHOW SINGLE PAGE
    // =========================
    public function show($id)
    {
        return CmsPage::findOrFail($id);
    }

    // =========================
    // ADMIN: UPDATE PAGE
    // =========================
    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);

        $page->update($request->only([
            'title',
            'content',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'status'
        ]));

        return response()->json([
            'message' => 'Page updated successfully',
            'data' => $page
        ]);
    }

    // =========================
    // ADMIN: DELETE PAGE
    // =========================
    public function destroy($id)
    {
        CmsPage::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ]);
    }

    // =========================
    // PUBLIC: GET PAGE BY SLUG
    // =========================
    public function getBySlug($slug)
    {
        return CmsPage::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
    }
}