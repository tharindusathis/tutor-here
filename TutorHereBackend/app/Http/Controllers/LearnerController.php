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

    public function requests($id){
        $requests =  DB::select('
         SELECT
            learnerlocation.address,
            request.payment,
            request.created_at,
            `subject`.`name`,
            `subject`.grade,
            `subject`.syllabus_from,
            CONCAT( tutor.fname, " ", tutor.lname ) AS tutor_name,
            CONCAT( `subject`.`grade`, ", ", `subject`.syllabus_from ) AS syllabus,
            tutor.fname,
            tutor.mobile,
            tutor.email,
            request.date,
            request.start_time,
            `subject`.`name` AS subject_name,
            request.end_time,
            request.dist,
            request.idRequest,
            request.`status`
        FROM
            request
            INNER JOIN tutor_has_subject ON request.Tutor_has_Subject_Tutor_idTutor = tutor_has_subject.Tutor_idTutor
            AND request.Tutor_has_Subject_Subject_idSubject = tutor_has_subject.Subject_idSubject
            INNER JOIN `subject` ON tutor_has_subject.Subject_idSubject = `subject`.idSubject
            INNER JOIN tutor ON tutor_has_subject.Tutor_idTutor = tutor.idTutor
            INNER JOIN learnerlocation ON request.LearnerLocation_idLearnerLocation = learnerlocation.idLearnerLocation
        WHERE
            request.Learner_idLearner = ?
        ',
                [$id]
        );
        return response()->json($requests);
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
