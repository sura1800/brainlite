<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exhibitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ApiExhibitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $exhibitors = Exhibitor::where('status', 1)->get(['logo', 'link']);
            if ($exhibitors && $exhibitors->count() > 0) {

                $baseUrl = Config::get('app_url.asset_base_url');
                $exhibitorFullUrl = $exhibitors->map(function ($item, $key) use ($baseUrl) {
                    $item->logo = $baseUrl . $item->logo;
                    return $item;
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Data fetched successfully',
                    'data' => $exhibitorFullUrl->toArray()
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
     * @param  \App\Models\Exhibitor  $exhibitor
     * @return \Illuminate\Http\Response
     */
    public function show(Exhibitor $exhibitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exhibitor  $exhibitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exhibitor $exhibitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exhibitor  $exhibitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exhibitor $exhibitor)
    {
        //
    }
}
