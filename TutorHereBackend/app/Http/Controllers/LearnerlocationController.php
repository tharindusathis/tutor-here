<?php

namespace App\Http\Controllers;

use App\Models\Learnerlocation;
use Illuminate\Http\Request;
use DB;

class LearnerlocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Learnerlocation::all();
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
        //
        return Learnerlocation::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Learnerlocation  $learnerlocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Learnerlocation::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Learnerlocation  $learnerlocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Learnerlocation $learnerlocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Learnerlocation  $learnerlocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Learnerlocation $learnerlocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Learnerlocation  $learnerlocation
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        // $item = Learnerlocation::findOrFail($id);
        // $item->delete();
        DB::table('learnerlocation')->where('idLearnerLocation', '=', $id)->delete();
        return 204;
    }
}
