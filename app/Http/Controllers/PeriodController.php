<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstructorResource;
use App\Http\Resources\PeriodResource;
use App\Models\Instructor;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodController extends Controller
{
    public function index(Instructor $instructor)
    {
        $periods = Period::get()->where('instructor_id', $instructor->id);

        if (sizeof($periods) == 0) {
            return response()->json(['response' => "There are no classes available!"]);
        }

        return PeriodResource::collection($periods);
    }

    public function add(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required',
                'time' => 'required',
                'price' => 'required',
                'status' => 'required',
                'instructor_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $period = Period::create([
            'date' => $request->time,
            'time' => $request->date,
            'price' => $request->price,
            'status' => $request->status,
            'instructor_id' => $request->instructor_id,
        ]);


        return response()->json(['response' => 'You have been successfully added new class!', 'created_class' => new PeriodResource($period)]);
    }

    public function update(Request $request, Period $period)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'status' => 'required',
            ]
        );


        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $period->status = $request->status;

        $period->save();


        return response()->json(['response' => 'You have successfully changed status of class!']);
    }
}
