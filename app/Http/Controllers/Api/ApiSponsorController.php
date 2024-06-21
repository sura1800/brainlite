<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorCategory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ApiSponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $baseUrl = Config::get('app_url.asset_base_url');
            $sponsors = SponsorCategory::has('sponsors')->with(['sponsors' => function (Builder $query) use ($baseUrl) {
                $query->where('status', 1);
            }])->where('status', 1)->orderBy('order')->get();

            if ($sponsors && $sponsors->count() > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data fetched successfully',
                    'data' => $sponsors->toArray()
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
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsor $sponsor)
    {
        //
    }
}
