<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetRequest;
use App\Http\Requests\UpdateSetRequest;
use App\Models\Set;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Log as Logger;

class SetController extends Controller
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
     * @param  \App\Http\Requests\StoreSetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSetRequest $request)
    {
        // Retrieve the validated input data
        $validated = $request;

        $duration = ($validated->duration_hours || $validated->duration_minutes || $validated->duration_seconds) ? ($validated->duration_hours * 60 * 60) + ($validated->duration_minutes * 60) + ($validated->duration_seconds) : null;

        $set = new Set;
        $set->log_id = $validated->log_id;
        $set->order = $validated->order;
        $set->sets = $validated->sets;
        $set->reps = $validated->reps;
        $set->weight = $validated->weight;
        $set->weight_added = $validated->weight_added;
        $set->weight_assisted = $validated->weight_assisted;
        $set->duration = $duration;
        $set->distance = $validated->distance;
        $set->unit_id = $validated->distance_unit;

        $set->save();

        return redirect()->action([LogController::class, 'show'], $set->log->id)->with('status', 'set-created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function show(Set $set)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function edit(Set $set)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSetRequest  $request
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSetRequest $request, Set $set)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Set $set)
    {
        $set->delete();

        Set::whereNull('deleted_at')
            ->where('log_id', $set->log_id)
            ->where('order', '>', $set->order)
            ->decrement('order');

        return redirect()->action([LogController::class, 'show'], $set->log_id);

    }
}
