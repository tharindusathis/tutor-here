<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;
use DB;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tutor::all();
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

  public function findTutors(Request $request)
    {
        $subject_name = '%' . $request->subject_name . '%';
        //$subject_name = $request->subject_name ;
        $date = $request->date;
        //$grade = $request->grade;
        //$syllabus_from = $request->syllabus_from;
        //$no_grade = $request->no_grade;

        //filer Subject + Date

        $tutors = null;
        $tutor_ids = null;
        $tutors = DB::select("
            SELECT DISTINCT
                tutor.idTutor, CONCAT(tutor.fname,\" \",tutor.lname) AS tutor_name, timeslots.start_time, timeslots.end_time, hourly_rate, rating
            FROM
                tutor
                INNER JOIN
                    ( SELECT  Tutor_idTutor,
                        CAST(start_datetime AS TIME ) as start_time,
                        CAST(end_datetime AS TIME ) as end_time
                        FROM singletimeslot WHERE CAST( start_datetime AS DATE ) = ?
                    UNION SELECT Tutor_idTutor,
                        CAST(start_time AS TIME )  as start_time ,
                        CAST(end_time AS TIME )  as end_time
                        FROM weeklytimeslot WHERE week_day = DAYOFWEEK( ? ) )
                AS timeslots ON timeslots.Tutor_idTutor = tutor.idTutor
                INNER JOIN
                (
                    SELECT * FROM tutor_has_subject WHERE tutor_has_subject.Subject_idSubject IN
                    (	SELECT idSubject FROM `subject`
                        WHERE UPPER(`name`) LIKE ?
                    )
                ) As t_s ON t_s.Tutor_idTutor = tutor.idTutor 	ORDER BY
		    tutor.idTutor",
            [
                $date,
                $date,
                $subject_name
            ]
        );

        $tutor_ids = collect($tutors)->pluck('idTutor')->unique();

        $tutor_subjects = DB::select("
            SELECT
            `subject`.idSubject,
            tutor.idTutor,
            `subject`.`name`,
            `subject`.grade,
            `subject`.syllabus_from,
            hourly_rate
            FROM
            tutor_has_subject
            INNER JOIN tutor ON tutor_has_subject.Tutor_idTutor = tutor.idTutor
            INNER JOIN `subject` ON tutor_has_subject.Subject_idSubject = `subject`.idSubject");

        $tutor_subjects = collect($tutor_subjects)->whereIn('idTutor', $tutor_ids);

        $tutor_locations = DB::select("
            SELECT
            tutorlocation.idTutorLocation,
            tutorlocation.Tutor_idTutor AS idTutor,
            tutorlocation.city,
            tutorlocation.lat,
            tutorlocation.lng
            FROM
            tutorlocation
        ");

        $tutor_locations = collect($tutor_locations)->whereIn('idTutor', $tutor_ids);

        return response()->json(['timeslots' => $tutors, 'subjects' => $tutor_subjects, 'locations' => $tutor_locations, 'ids' => $tutor_ids   ]);


    }

    public function findTutorsWithGrade(Request $request)
    {
        //$subject_name = '%' . $request->subject_name . '%';
        $subject_name = $request->subject_name ;
        $date = $request->date;
        $grade = $request->grade;
        $syllabus_from = $request->syllabus_from;
        //$no_grade = $request->no_grade;

        //filer Subject + Date

        $tutors = null;
        $tutor_ids = null;
        $tutors = DB::select("
            SELECT DISTINCT
                tutor.idTutor, CONCAT(tutor.fname,\" \",tutor.lname) AS tutor_name,   timeslots.start_time, timeslots.end_time, hourly_rate, rating
            FROM
                tutor
                INNER JOIN
                    ( SELECT Tutor_idTutor,
                        CAST(start_datetime AS TIME ) as start_time,
                        CAST(end_datetime AS TIME ) as end_time
                        FROM singletimeslot WHERE CAST( start_datetime AS DATE ) = ?
                    UNION SELECT Tutor_idTutor,
                        CAST(start_time AS TIME )  as start_time ,
                        CAST(end_time AS TIME )  as end_time
                        FROM weeklytimeslot WHERE week_day = DAYOFWEEK( ? ) )
                AS timeslots ON timeslots.Tutor_idTutor = tutor.idTutor
                INNER JOIN
                (
                    SELECT * FROM tutor_has_subject WHERE tutor_has_subject.Subject_idSubject IN
                    (	SELECT idSubject FROM `subject`
                        WHERE UPPER(`name`) = UPPER( ? )
                        AND UPPER(`grade`) =     UPPER( ? )
                        AND UPPER(`syllabus_from`) = UPPER( ? )
                    )
                ) As t_s ON t_s.Tutor_idTutor = tutor.idTutor 	ORDER BY
		    tutor.idTutor",
            [
                $date,
                $date,
                $subject_name,
                $grade,
                $syllabus_from
            ]
        );


       $tutor_ids = collect($tutors)->pluck('idTutor')->unique();

        $tutor_subjects = DB::select("
            SELECT
            `subject`.idSubject,
            tutor.idTutor,
            `subject`.`name`,
            `subject`.grade,
            `subject`.syllabus_from,
            hourly_rate
            FROM
            tutor_has_subject
            INNER JOIN tutor ON tutor_has_subject.Tutor_idTutor = tutor.idTutor
            INNER JOIN `subject` ON tutor_has_subject.Subject_idSubject = `subject`.idSubject");



        $tutor_subjects = collect($tutor_subjects)->whereIn('idTutor', $tutor_ids);


        $tutor_locations = DB::select("
            SELECT
            tutorlocation.idTutorLocation,
            tutorlocation.Tutor_idTutor AS idTutor,
            tutorlocation.city,
            tutorlocation.lat,
            tutorlocation.lng
            FROM
            tutorlocation
        ");

        $tutor_locations = collect($tutor_locations)->whereIn('idTutor', $tutor_ids);

        return response()->json(['timeslots' => $tutors, 'subjects' => $tutor_subjects, 'locations' => $tutor_locations, 'ids' => $tutor_ids   ]);

    }


    public function subjects($id)
    {
        $subs = DB::select('
            SELECT
                `subject`.`name` AS subject_name,
                `subject`.grade,
                `subject`.syllabus_from,
                tutor_has_subject.hourly_rate
            FROM
                `subject`
                LEFT OUTER JOIN tutor_has_subject ON tutor_has_subject.Subject_idSubject = `subject`.idSubject
            WHERE
                tutor_has_subject.Tutor_idTutor =' . $id
        );
        return $subs;
    }


    public function requests($id){
        $requests =  DB::select('
         SELECT
            request.idRequest,
            request.`status`,
            request.Tutor_has_Subject_Tutor_idTutor,
            request.Learner_idLearner AS idLearner,
            request.payment,
            request.date,
            request.dist,
            request.start_time,
            request.end_time,
            CONCAT(learner.fname," ",learner.lname) AS learner_name,
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
            learner.email
            FROM
            request
            INNER JOIN learnerlocation ON request.LearnerLocation_idLearnerLocation = learnerlocation.idLearnerLocation
            INNER JOIN learner ON request.Learner_idLearner = learner.idLearner AND learnerlocation.Learner_idLearner = learner.idLearner
            INNER JOIN tutor_has_subject ON request.Tutor_has_Subject_Tutor_idTutor = tutor_has_subject.Tutor_idTutor AND request.Tutor_has_Subject_Subject_idSubject = tutor_has_subject.Subject_idSubject
            INNER JOIN `subject` ON tutor_has_subject.Subject_idSubject = `subject`.idSubject
            WHERE Tutor_has_Subject_Tutor_idTutor = ? AND  request.`status` IN (0,1)
            ORDER BY
            request.created_at ASC
        ',
                [$id]
        );
        return response()->json(['all' => $requests]);
    }

    public function requestsOld($id){
        $requests =  DB::select('
         SELECT
            request.idRequest,
            request.`status`,
            request.Tutor_has_Subject_Tutor_idTutor,
            request.Learner_idLearner AS idLearner,
            request.payment,
            request.date,
            request.start_time,
            request.end_time,
            CONCAT(learner.fname," ",learner.lname) AS learner_name,
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
            learner.email
            FROM
            request
            INNER JOIN learnerlocation ON request.LearnerLocation_idLearnerLocation = learnerlocation.idLearnerLocation
            INNER JOIN learner ON request.Learner_idLearner = learner.idLearner AND learnerlocation.Learner_idLearner = learner.idLearner
            INNER JOIN tutor_has_subject ON request.Tutor_has_Subject_Tutor_idTutor = tutor_has_subject.Tutor_idTutor AND request.Tutor_has_Subject_Subject_idSubject = tutor_has_subject.Subject_idSubject
            INNER JOIN `subject` ON tutor_has_subject.Subject_idSubject = `subject`.idSubject
            WHERE Tutor_has_Subject_Tutor_idTutor = ? AND  request.`status` IN (2,3)
            ORDER BY
            request.created_at ASC
        ',
                [$id]
        );
        return response()->json(['all' => $requests]);
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
        return Tutor::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tutor $tutor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Tutor::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutor $tutor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Tutor::findOrFail($id);
        $item->update($request->all());

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tutor $tutor)
    {
        //
    }


    public function locations($id)
    {
        $items = DB::select('
            SELECT
                *
            FROM
                tutorlocation
            WHERE
                tutorlocation.Tutor_idTutor =' . $id
        );
        return $items;
    }

    public function singletimeslots($id)
    {
        $items = DB::select('
            SELECT
                *
            FROM
                singletimeslot
            WHERE
                singletimeslot.Tutor_idTutor =' . $id
        );
        return $items;
    }
    public function weeklytimeslots($id)
    {
        $items = DB::select('
            SELECT
                *
            FROM
                weeklytimeslot
            WHERE
                weeklytimeslot.Tutor_idTutor =' . $id
        );
        return $items;
    }

}
