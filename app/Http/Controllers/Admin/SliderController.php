<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Slider access|Slider create|Slider edit|Slider delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Slider create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Slider edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Slider delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::get();
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.add');
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
            'title' => 'max:250',
            'slide_img' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500'
        ]);

        if ($request->hasFile('slide_img')) {
            if ($request->file('slide_img')->isValid()) {
                $imagePath = upload_file($request->slide_img, "",  Config::get('app_url.asset_slider_url'), 650);
                $validated['slide_img'] =  $imagePath;
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        Slider::create($validated);
        return redirect()->back()->withSuccess('Slider added !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact(['slider']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $validated =  $request->validate([
            'title' => 'max:250',
            'slide_img' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
        ]);

        if ($request->hasFile('slide_img')) {
            if ($request->file('slide_img')->isValid()) {
                $imagePath = upload_file($request->slide_img, "",  Config::get('app_url.asset_slider_url'), 650);
                $validated['slide_img'] =  $imagePath;
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        // dd($validated);
        $slider->update($validated);
        return redirect()->back()->withSuccess('Slider updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        File::delete(public_path($slider->slide_img));
        $slider->delete();
        return to_route('admin.sliders.index')->with('success', 'Slider deleted successfully');
    }
}
