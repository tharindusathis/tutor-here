<?php

namespace App\Http\Controllers;

use App\Models\Request as ARequest;
use Illuminate\Http\Request;
use DB;

define ('STATUS_REQUEST_PENDING', 0);
define ('STATUS_REQUEST_ACCEPTED', 1);
define ('STATUS_REQUEST_DECLINED', 2);
define ('STATUS_REQUEST_FINISHED', 3);



class RequestController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ARequest::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['status'] = STATUS_REQUEST_DECLINED;
        return ARequest::create($request->all());
    }

    public function calculateFare(Request $request)
    {
        //
        return ARequest::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ARequest::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(ARequest $arequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $arequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ARequest $arequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(ARequest $arequest)
    {
        //
    }
}
