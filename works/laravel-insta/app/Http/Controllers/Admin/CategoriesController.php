<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $categories;

    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $categories = $this->categories->withCount('categoryPost')->latest()->get();
        $uncategorizedCount = Post::whereDoesntHave('categoryPost')->count();

        return view('admin.categories.index')
            ->with('categories', $categories)
            ->with('uncategorizedCount', $uncategorizedCount);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        $this->categories->create($request->only('name'));

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $id,
        ]);

        $this->categories->findOrFail($id)->update($request->only('name'));

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->categories->findOrFail($id)->delete();

        return redirect()->back();
    }
}
