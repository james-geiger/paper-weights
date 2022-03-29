<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMuscleGroupRequest;
use App\Http\Requests\UpdateMuscleGroupRequest;
use App\Models\MuscleGroup;

class MuscleGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreMuscleGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMuscleGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MuscleGroup  $MuscleGroup
     * @return \Illuminate\Http\Response
     */
    public function show(MuscleGroup $MuscleGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MuscleGroup  $MuscleGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(MuscleGroup $MuscleGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMuscleGroupRequest  $request
     * @param  \App\Models\MuscleGroup  $MuscleGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMuscleGroupRequest $request, MuscleGroup $MuscleGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MuscleGroup  $MuscleGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(MuscleGroup $MuscleGroup)
    {
        //
    }
}
