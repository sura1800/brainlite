<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delegate;
use Illuminate\Http\Request;

class ApiDelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $delegates = Delegate::where('status', 1)->orderBy('first_name')->get();
            if ($delegates  && $delegates->count() > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data fetched successfully',
                    'data' => $delegates->toArray()
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
     * @param  \App\Models\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function show(Delegate $delegate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delegate $delegate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delegate $delegate)
    {
        //
    }
}
