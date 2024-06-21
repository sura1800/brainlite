<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Page access|Page create|Page edit|Page delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Page create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Page edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Page delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::get();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'title' => 'required|string|unique:pages,title',
            'main_image' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'content' => 'required|max:99999999',
            'short_content' => 'max:2000',
            'meta_title' => 'max:500',
            'meta_description' => 'max:5000',
            'meta_keywords' => 'max:1000',
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['meta_title'] = $validated['title'];
        $validated['meta_description'] = Str::substr(strip_tags($validated['content']), 0, 120);
        $validated['meta_keywords'] = str_replace('-', ',', $validated['slug']);

        if ($request->hasFile('main_image')) {
            if ($request->file('main_image')->isValid()) {
                $image = $request->main_image;
                $new_image = random_fileName($validated['slug'], $image->extension());

                $path = 'upload/page/images/';
                $imagePath = $path . $new_image;

                $pathReal = env('ASSET_BASE_PATH') . $path;
                $imagePathReal = env('ASSET_BASE_PATH') . $imagePath;

                if (!File::exists($pathReal)) {
                    File::makeDirectory($pathReal, 0755, true, true);
                }
                $iim = Image::make($image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imagePathReal);

                $validated['main_image'] =  $imagePath;
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        Page::create($validated);
        return redirect()->back()->withSuccess('Page added !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        // return view('admin.page.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $validated =  $request->validate([
            'title' => "required|string|unique:pages,title, $page->id",
            'main_image' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'content' => 'required|max:99999999',
            'short_content' => 'max:2000',
            'meta_title' => 'max:500',
            'meta_description' => 'max:5000',
            'meta_keywords' => 'max:1000',
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['meta_title'] = $validated['title'];
        $validated['meta_description'] = Str::substr(strip_tags($validated['content']), 0, 120);
        $validated['meta_keywords'] = str_replace('-', ',', $validated['slug']);

        if ($request->hasFile('main_image')) {
            if ($request->file('main_image')->isValid()) {
                $image = $request->main_image;
                $new_image = random_fileName($validated['slug'], $image->extension());

                $path = 'upload/page/images/';
                $imagePath = $path . $new_image;

                $pathReal = env('ASSET_BASE_PATH') . $path;
                $imagePathReal = env('ASSET_BASE_PATH') . $imagePath;

                if (!File::exists($pathReal)) {
                    File::makeDirectory($pathReal, 0755, true, true);
                }
                $iim = Image::make($image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imagePathReal);

                $validated['main_image'] =  $imagePath;
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        $page->update($validated);
        return redirect()->back()->withSuccess('Page updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->back()->withSuccess('Page deleted !!!');
    }
}
