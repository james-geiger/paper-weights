<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetRequest;
use App\Http\Requests\UpdateSetRequest;
use App\Models\Set;

use App\Http\Controllers\LogController;

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

        $set = Set::create([
            'log_id' => $request->log_id,
            'order' => $request->order,
            'reps' => $request->reps,
            'weight' => $request->weight
        ]);

        return back();
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
        //
    }
}
