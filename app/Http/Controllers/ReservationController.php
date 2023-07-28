<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function getFromUser()
    {
        $reservations = Reservation::get()->where('user_id', Auth::user()->id);

        if (sizeof($reservations) == 0) {
            return response()->json(['response' => "There are no reservations made!"]);
        }

        return ReservationResource::collection($reservations);
    }

    public function getFromInstructor()
    {
        $currentDate = Carbon::now()->toDateString();

        $reservations = Reservation::whereHas('period', function ($query) use ($currentDate) {
            $query->whereDate('date', $currentDate);
        })
            ->where('instructor_id', Auth::instructor()->id)
            ->get();

        // $reservations = Reservation::where('instructor_id', Auth::instructor()->id)
        //     ->whereDate('date', $currentDate)
        //     ->get();

        //$reservations = Reservation::get()->where('instructor_id', Auth::instructor()->id);

        if (sizeof($reservations) == 0) {
            return response()->json(['response' => "There are no reservations made for today!"]);
        }

        return ReservationResource::collection($reservations);
    }

    public function add(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'totalPrice' => 'required',
                'period_id' => 'required',
                'user_id' => 'required',
                'status' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $reservation = Reservation::create([
            'totalPrice' => $request->totalPrice,
            'period_id' => $request->period_id,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);


        return response()->json(['success' => 'true', 'response' => 'You have been successfully made reservation!', 'created_reservation' => new ReservationResource($reservation)]);
    }

    public function update(Request $request, Reservation $reservation)
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


        $reservation->status = $request->status;

        $reservation->save();


        return response()->json(['response' => 'You have successfully changed status of reservation!']);
    }
}
