<?php

namespace App\Http\Controllers;

use App\Models\Learner;
use Illuminate\Http\Request;
use DB;

class LearnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Learner::all();
    }


    public function locations($id)
    {
        $subs = DB::select('
            SELECT
                learnerlocation.idLearnerLocation,
                learnerlocation.Learner_idLearner,
                learnerlocation.address,
                learnerlocation.tag,
                learnerlocation.district,
                learnerlocation.lat,
                learnerlocation.lng
            FROM
                learnerlocation
            WHERE
                learnerlocation.Learner_idLearner =' . $id
        );
        return $subs;
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
        return Learner::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Learner  $learner
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return Learner::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Learner  $learner
     * @return \Illuminate\Http\Response
     */
    public function edit(Learner $learner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Learner  $learner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Learner::findOrFail($id);
        $item->update($request->all());

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Learner  $learner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Learner $learner)
    {
        //
    }
}
