<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagesRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function index()
    {
        $perPage = request()->get('per_page')?:10;
        $query = request()->get('q', '');

        return Inertia::render('Admin/Page/Index', [
            'filters' => [
                'q' => $query,
                'per_page' => $perPage
            ],
            'pages' => Page::where('title', 'LIKE', "%{$query}%")
                ->orWhere('slug', 'LIKE', "%{$query}%")
                ->paginate($perPage)
                ->withQueryString()
                ->through(fn($page) => [
                    'id' => $page->id,
                    'slug' => $page->slug,
                    'title' => $page->title,
                    'meta_title' => $page->meta_title,
                    'size' => $page->size,
                    'classes' => $page->classes,
                    'meta_description' => $page->meta_description,
                    'meta_keywords' => $page->meta_keywords,
                    'content' => $page->content,
                ])
        ]);
    }

    /**
     * show specific resource
     *
     * @param Page $page
     * @return \Inertia\Response
     */
    public function show(Page $page)
    {
        $page->only([
            'title',
            'meta_title',
            'size',
            'classes',
            'meta_description',
            'meta_keywords',
            'content',
        ]);

        return Inertia::render('Page/Show', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Page/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PagesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PagesRequest $request)
    {
        $page = Page::create($request->validated());

        return redirect()->route('admin.page.index')->with('success', "Dodatna Stranica '$page->title' je uspešno kreirana.");
    }

    /**
     * show specific resource
     *
     * @param Page $page
     * @return \Inertia\Response
     */
    public function edit(Page $page)
    {
        $page->only([
            'slug',
            'title',
            'meta_title',
            'size',
            'classes',
            'meta_description',
            'meta_keywords',
            'content',
        ]);

        return Inertia::render('Admin/Page/Edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Page $page
     * @param PagesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Page $page, PagesRequest $request)
    {
        $page->update($request->validated());

        return redirect()->route('admin.page.index')->with('success', "Stranica '$page->title' je uspešno izmenjena.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->back()->with('success', 'Dodatna Stranica je uspešno obrisana!');
    }
}
