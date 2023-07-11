<?php

namespace App\Http\Controllers;

use App\Http\Resources\MountainCollection;
use App\Http\Resources\MountainResource;
use App\Models\Mountain;
use Illuminate\Http\Request;

class MountainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mountainss = Mountain::all();

        return MountainResource::collection($mountainss);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mountain $mountain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mountain $mountain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mountain $mountain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mountain $mountain)
    {
        //
    }
}
