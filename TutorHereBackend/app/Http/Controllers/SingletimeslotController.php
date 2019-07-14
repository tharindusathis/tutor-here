<?php

namespace App\Http\Controllers;

use App\Models\Singletimeslot;
use Illuminate\Http\Request;
use DB;

class SingletimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Singletimeslot::all();
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
        // $start = $request->start_date;
        // $start = str_replace("-",":",$start);
        // $start = $start . " " .  $request->start_time . ":00";

        // $end = $request->end_date;
        // $end = str_replace("-",":",$end);
        // $end = $end . " " .  $request->end_time . ":00";

        // $request->merge(['start_datetime' => $start]);
        // $request->merge(['end_datetime' => $end]);

        return Singletimeslot::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Singletimeslot  $singletimeslot
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Singletimeslot::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Singletimeslot  $singletimeslot
     * @return \Illuminate\Http\Response
     */
    public function edit(Singletimeslot $singletimeslot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Singletimeslot  $singletimeslot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Singletimeslot $singletimeslot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Singletimeslot  $singletimeslot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Singletimeslot $singletimeslot)
    {
        //
    }

       public function delete(Request $request, $id)
    {
        DB::table('singletimeslot')->where('idSingleTimeslot', '=', $id)->delete();
        return 204;
    }
}
