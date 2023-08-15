<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationEquipmentResource;
use App\Http\Resources\ReservationResource;
use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\ReservationEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ReservationEquipmentController extends Controller
{

    public function addReservationEquipment(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        $equipment = Equipment::findOrFail($request->equipment_id);

        $reservation->equipment()->attach($request->equipment_id, ['equipmentInformation' => $request->equipmentInformation]);
        $reservation->totalPrice = $reservation->totalPrice + $equipment->price;
        $reservation->update();
        return response()->json(['success' => 'true', 'message' => 'Equipment added to reservation successfully']);
    }

    public function getReservationEquipment($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservationEquipment = $reservation->equipment;

        return response()->json([
            'reservation_equipment' => $reservationEquipment,
        ]);
    }

    public function delete($reservationId, $equipmentId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $equipment = Equipment::findOrFail($equipmentId);

        $reservation->totalPrice = $reservation->totalPrice - $equipment->price;
        $reservation->update();

        $reservation->equipment()->detach($equipmentId);

        return response()->json(['message' => 'Reservation Equipment deleted successfully', 'newPrice' => $reservation->totalPrice]);
    }
}
