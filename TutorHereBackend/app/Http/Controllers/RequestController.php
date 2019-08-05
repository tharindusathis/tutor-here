<?php

namespace App\Http\Controllers;

use App\Models\Request as ARequest;
use Illuminate\Http\Request;
use DB;

define ('STATUS_REQUEST_PENDING', 0);
define ('STATUS_REQUEST_ACCEPTED', 1);
define ('STATUS_REQUEST_DECLINED', 2);

define ('STATUS_REQUEST_COMING', 3);
define ('STATUS_REQUEST_STARTED', 4);
define ('STATUS_REQUEST_FINISHED', 5);

define ('STATUS_REQUEST_DELETED', 9);



class RequestController extends Controller
{


    public function acceptRequest($id){
        DB::table('request')
        ->updateOrInsert(
            ['idRequest' => $id],
            ['status' => STATUS_REQUEST_ACCEPTED]
        );
        return response()->json("Done Accepted", 200);
    }
    public function deleteRequest($id){
        DB::table('request')
        ->updateOrInsert(
            ['idRequest' => $id],
            ['status' => STATUS_REQUEST_DELETED]
        );
        return response()->json("Done Accepted", 200);
    }
    public function declineRequest($id){
         DB::table('request')
        ->updateOrInsert(
            ['idRequest' => $id],
            ['status' => STATUS_REQUEST_DECLINED]
        );
        return response()->json("Done Declined", 200);
    }
    public function comingRequest($id){
         DB::table('request')
        ->updateOrInsert(
            ['idRequest' => $id],
            ['status' => STATUS_REQUEST_COMING]
        );
        return response()->json("Done Coming", 200);
    }

    public function startRequest($id){
         DB::table('request')
        ->updateOrInsert(
            ['idRequest' => $id],
            ['status' => STATUS_REQUEST_STARTED]
        );
        return response()->json("Done Start", 200);
    }

    public function finishRequest($id){
         DB::table('request')
        ->updateOrInsert(
            ['idRequest' => $id],
            ['status' => STATUS_REQUEST_FINISHED]
        );
        return response()->json("Done Finish", 200);
    }

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
        $request['status'] = STATUS_REQUEST_PENDING;
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

     public function showOne($id){
        $requests =  DB::select('
        SELECT
            request.idRequest,
            request.`status`,
            request.dist,
            request.Tutor_has_Subject_Tutor_idTutor,
            request.Learner_idLearner AS idLearner,
            request.payment,
            request.date,
            request.start_time,
            request.end_time,
            CONCAT( learner.fname, " ", learner.lname ) AS learner_name,
            CONCAT( tutor.fname, " ", tutor.lname ) AS tutor_name,
						tutor.rating AS tutor_rating,
            CONCAT( `subject`.`grade`, ", ", `subject`.syllabus_from ) AS syllabus,
            learner.mobile,
            learnerlocation.address,
            learnerlocation.tag,
            learnerlocation.district,
            learnerlocation.lat,
            learnerlocation.lng,
            `subject`.`name` AS subject_name,
            `subject`.grade,
            `subject`.syllabus_from,
            request.created_at,
            learner.email,
            tutor.email AS tutor_email,
            tutor.mobile AS tutor_mobile
        FROM
            request
            INNER JOIN learner ON request.Learner_idLearner = learner.idLearner
            INNER JOIN tutor_has_subject ON request.Tutor_has_Subject_Tutor_idTutor = tutor_has_subject.Tutor_idTutor
            AND request.Tutor_has_Subject_Subject_idSubject = tutor_has_subject.Subject_idSubject
            INNER JOIN `subject` ON tutor_has_subject.Subject_idSubject = `subject`.idSubject
            INNER JOIN `tutor` ON tutor_has_subject.Tutor_idTutor = `tutor`.idTutor
            INNER JOIN learnerlocation ON learnerlocation.Learner_idLearner = learner.idLearner
            AND request.LearnerLocation_idLearnerLocation = learnerlocation.idLearnerLocation
        WHERE
            idRequest = ?
        ',
                [$id]
        );
        return  ($requests);
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
