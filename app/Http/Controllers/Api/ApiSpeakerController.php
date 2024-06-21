<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ApiSpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $speakers = Speaker::where('status', 1)->get();
            if ($speakers && $speakers->count() > 0) {
                $baseUrl = Config::get('app_url.asset_base_url');
                $speakersFullUrl = $speakers->map(function ($item, $key) use ($baseUrl) {
                    $item->avatar = $baseUrl . $item->avatar;
                    return $item;
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Data fetched successfully',
                    'data' => $speakersFullUrl->toArray()
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
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speaker $speaker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speaker $speaker)
    {
        //
    }
}
