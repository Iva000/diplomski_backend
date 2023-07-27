<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstructorResource;
use App\Http\Resources\PeriodResource;
use App\Models\Instructor;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PeriodController extends Controller
{

    public function index($id)
    {
        //$instructor = Instructor::where('id', $id)->first();

        $periods = Period::where('instructor_id', $id)->get();

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

    public function createPeriods(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date|after_or_equal:dateFrom',
            'timeStart' => 'required|date_format:H:i',
            'timeFinish' => 'required|date_format:H:i|after:timeStart',
            'instructor_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $dateFrom = Carbon::parse($request->dateFrom);
        $dateTo = Carbon::parse($request->dateTo);
        $timeStart = Carbon::parse($request->timeStart);
        $timeFinish = Carbon::parse($request->timeFinish);
        $instructor = Instructor::where('id', $request['instructor_id'])->first();

        $periods = [];

        while ($dateFrom <= $dateTo) {
            $startTime = $dateFrom->copy()->setTime($timeStart->hour, $timeStart->minute);
            $endTime = $dateFrom->copy()->setTime($timeFinish->hour, $timeFinish->minute);

            while ($startTime <= $endTime) {
                $periods[] = [
                    'date' => $dateFrom->format('Y-m-d'),
                    'time' => $startTime->format('H:i:s'),
                    'price' => $instructor->price,
                    'status' => 0,
                    'instructor_id' => $request->instructor_id,
                ];

                $startTime->addHour();
            }

            $dateFrom->addDay();
        }

        Period::insert($periods);

        return response()->json(['success' => 'true', 'response' => 'You have successfully added new class!']);
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
