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
    public function getFromUser($id, $status)
    {
        $reservations = Reservation::where('user_id', $id)
            ->where('status', $status)
            ->get();

        return ReservationResource::collection($reservations);
    }

    public function getPreviousFromUser($id)
    {
        $reservations = Reservation::where('user_id', $id)
            ->whereIn('status', [1, 2, 0])
            ->get();

        return ReservationResource::collection($reservations);
    }

    public function getFromInstructor($id, $status)
    {
        $reservations = Reservation::with('user')
            ->whereHas('period', function ($query) use ($id) {
                $query->where('instructor_id', $id);
            })
            ->where('status', $status)
            ->get();

        return ReservationResource::collection($reservations);
    }

    public function getSchedule($id)
    {
        $currentDate = Carbon::now()->toDateString();

        $reservations = Reservation::with('user')
            ->whereHas('period', function ($query) use ($id) {
                $query->where('instructor_id', $id)
                    ->whereDate('date', Carbon::now()->toDateString());
            })
            ->where('status', 1)
            ->get();

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
        $validatedData = $request->validate([
            'status' => '',
            'totalPrice' => ''
        ]);

        $reservation = Reservation::find($request->id);
        $reservation->update($validatedData);


        return response()->json(['response' => 'You have successfully changed status of reservation!']);
    }
}
