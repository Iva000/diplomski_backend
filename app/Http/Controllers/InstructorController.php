<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstructorResource;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::all();
        return InstructorResource::collection($instructors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'skiSchool' => 'required|string|max:255',
                'experience' => 'required',
                'price' => 'required',
                'activity' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|min:5',
                'phoneNumber' => 'required|string|max:255',
                'status' => 'required',
                'photo' => 'required|string|max:255',
                'mountain_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $instructor = Instructor::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'skiSchool' => $request->skiSchool,
            'experience' => $request->experience,
            'price' => $request->price,
            'activity' => $request->activity,
            'description' =>  $request->description,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'phoneNumber' => $request->phoneNumber,
            'status' => $request->status,
            'photo' => $request->photo,
            'mountain_id' => $request->mountain_id
        ]);


        $token = $instructor->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => 'true',
            'response' => 'You have been successfully registerd!', 'created_user' => new InstructorResource($instructor),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'skiSchool' => 'required|string|max:255',
            'experience' => 'required',
            'price' => 'required',
            'email' => '',
            'password' => '',
            'activity' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:255',
            'status' => 'required',
            'photo' => 'required|string|max:255',
            'mountain_id' => 'nullable|exists:mountains,id'
        ]);

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required|string|max:255',
        //         'surname' => 'required|string|max:255',
        //         'skiSchool' => 'required|string|max:255',
        //         'experience' => 'required',
        //         'price' => 'required',
        //         'email' => '',
        //         'password' => '',
        //         'activity' => 'required|string|max:255',
        //         'description' => 'required|string|max:255',
        //         'phoneNumber' => 'required|string|max:255',
        //         'status' => 'required',
        //         'photo' => 'required|string|max:255',
        //         'mountain_id' => 'required'


        //     ]
        // );


        // if ($validatedData->fails()) {
        //     return response()->json($validator->errors());
        // }

        $instructor = Instructor::find($request->id);

        // $instructor->name = $request->name;
        // $instructor->surname = $request->surname;
        // $instructor->skiSchool = $request->skiSchool;
        // $instructor->experience = $request->experience;
        // $instructor->price = $request->price;
        // $instructor->email = $request->email;
        // $instructor->password = $request->password;
        // $instructor->activity = $request->activity;
        // $instructor->description =  $request->description;
        // $instructor->phoneNumber = $request->phoneNumber;
        // $instructor->status = $request->status;
        // $instructor->photo = $request->photo;
        // $instructor->mountain_id = $request->mountain->id;

        $instructor->update($validatedData);


        return response()->json(['success' => 'true', 'response' => 'You have successfully changed your information!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructors)
    {
        //
    }

    public function login(Request $request)
    {
        if (!Auth::guard('instructor')->validate(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return response()->json(['success' => 'false']);
        }

        $instructor = Instructor::where('email', $request['email'])->first();

        $token = $instructor->createToken('auth_token')->plainTextToken;

        return response()->json(['success' => 'true', 'access_token' => $token, 'token_type' => 'instructor', 'instructor' => $instructor]);
    }

    public function logout()
    {

        auth()->user()->tokens()->delete();

        return response()->json(['response' => 'Logged out!']);
    }

    public function getInstructorsByStatus($status)
    {
        $instructors = Instructor::where('status', $status)->get();

        //return response()->json($instructors);
        return InstructorResource::collection($instructors);
    }
}
