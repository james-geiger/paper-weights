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

        $combine_like_sets = setting()->getUser($request->user(), 'combine-like-sets');

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

        if ($combine_like_sets && $validated->order > 1) {
            $last_set = Set::where('log_id', $validated->log_id)->where('order', $validated->order - 1)->first();
            if ($last_set->reps == $set->reps &&
                $last_set->weight == $set->weight &&
                $last_set->weight_added == $set->weight_added &&
                $last_set->weight_assisted == $set->weight_assisted &&
                $last_set->duration == $set->duration &&
                $last_set->distance == $set->distance &&
                $last_set->unit_id == $set->unit_id ) {
                $last_set->sets += $set->sets;
                $last_set->save();
            }
        } else {
            $set->save();
        }

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

        return redirect()->action([LogController::class, 'show'], $set->log_id);

    }
}
