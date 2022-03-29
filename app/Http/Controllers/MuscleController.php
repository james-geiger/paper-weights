<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMuscleRequest;
use App\Http\Requests\UpdateMuscleRequest;
use App\Models\Muscle;

class MuscleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreMuscleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMuscleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Muscle  $Muscle
     * @return \Illuminate\Http\Response
     */
    public function show(Muscle $Muscle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Muscle  $Muscle
     * @return \Illuminate\Http\Response
     */
    public function edit(Muscle $Muscle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMuscleRequest  $request
     * @param  \App\Models\Muscle  $Muscle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMuscleRequest $request, Muscle $Muscle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Muscle  $Muscle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Muscle $Muscle)
    {
        //
    }
}
