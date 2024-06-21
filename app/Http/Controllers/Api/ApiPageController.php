<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pages = Page::where(['status' => 1])->get(['title', 'slug']);

            if ($pages && $pages->count() > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data fetched successfully',
                    'data' => $pages->toArray()
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Data not found',
                    'data' => []
                ]);
            }           

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    public function pageDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->post(), [
                'page-slug' => ['required', 'string', 'exists:pages,slug'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 400);
            }

            $page = Page::where('slug', $validator->validated()['page-slug'])->first(['title', 'slug', 'group_id', 'main_image', 'content']);
            return response()->json([
                'status' => true,
                'message' => 'Data fetched successfully',
                'data' => $page->toArray()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
