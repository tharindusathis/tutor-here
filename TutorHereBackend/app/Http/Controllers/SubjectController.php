<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Subject::all();
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
        //return Subject::create($request->all());
        $sub = DB::table('subject')->where([
            ['name', '=', $request->name],
            ['grade', '=', $request->grade],
            ['syllabus_from', '=', $request->syllabus_from],
        ])->get();

        if (sizeof($sub) == 0){
            $sub = Subject::create($request->all());

            DB::table('tutor_has_subject')->insert([
                'Tutor_idTutor' => $request->Tutor_idTutor,
                'Subject_idSubject' => $sub->idSubject,
                'hourly_rate' => $request->hourly_rate
            ]);

            $ack = DB::table('tutor_has_subject')->where([
                ['Tutor_idTutor', '=', $request->Tutor_idTutor],
                ['Subject_idSubject', '=', $sub->idSubject],
            ])->get();
            return $ack;
        }else{
            DB::table('tutor_has_subject')->insert([
                'Tutor_idTutor' => $request->Tutor_idTutor,
                'Subject_idSubject' => $sub[0]->idSubject,
                'hourly_rate' => $request->hourly_rate
            ]);

            $ack = DB::table('tutor_has_subject')->where([
                ['Tutor_idTutor', '=', $request->Tutor_idTutor],
                ['Subject_idSubject', '=', $sub[0]->idSubject],
            ])->get();
            return $ack;
        }
    }

    public function findSubjects()
    {
        $subs = DB::select('
            SELECT
                `subject`.`name`,
                Count(`subject`.idSubject) AS subject_count
            FROM
                `subject`
            GROUP BY
                `subject`.`name`
            ORDER BY
                subject_count DESC
        ');
        return $subs;
    }
    public function findGrades(Request $request)
    {
        $grades = DB::select(
            "
            SELECT
                `subject`.idSubject,
                `subject`.grade,
                `subject`.`name`,
                `subject`.syllabus_from,
                CONCAT( SUBJECT.grade, \", \", SUBJECT.syllabus_from ) AS grade_name,
                COUNT( tutor_has_subject.Tutor_idTutor ) AS tutor_count
            FROM
                `subject`
                LEFT OUTER JOIN tutor_has_subject ON tutor_has_subject.Subject_idSubject = `subject`.idSubject
            WHERE
                `subject`.`name` LIKE :subject_name
            GROUP BY
                grade,syllabus_from,`name`
            ORDER BY
                tutor_count DESC
            ",
            [ 'subject_name' => '%' . $request->subject_name . '%']
        );
        return $grades;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Subject::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    public function mail()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }

    public function distinct(){
        $subject_names = DB::select('
            SELECT DISTINCT
                `subject`.`name` AS `subject_name`
            FROM
                `subject`
        ');
        $subject_types = DB::select('
            SELECT DISTINCT
                `subject`.`syllabus_from` AS `subject_type`
            FROM
                `subject`
        ');
        $subject_grades = DB::select('
            SELECT DISTINCT
                `subject`.`grade` AS `subject_grade`
            FROM
                `subject`
        ');

        $names = array_column($subject_names, 'subject_name');
        $types = array_column($subject_types, 'subject_type');
        $grades = array_column($subject_grades, 'subject_grade');

        return response()->json(
            [
                'names'=>$names,
                'types'=>$types,
                'grades'=>$grades
            ],200);
    }
}
