<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Models\Log;
use App\Models\Modifier;

use Inertia\Inertia;

use App\Http\Controllers\WorkoutController;

use Auth;

class LogController extends Controller
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
     * @param  \App\Http\Requests\StoreLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLogRequest $request)
    {
        // Retrieve the validated input data
        $validated = $request;

        $log = Log::create([
            'exercise_id' => $request->exercise_id,
            'workout_id' => $request->workout_id,
            'order' => $request->order,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->action([LogController::class, 'show'], $log->id)->with('status', 'log-created');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $Log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {

        $log->loadCount('sets');
        $log->loadSum('sets', 'reps');

        $modifiers = Modifier::all();

        $workout = $log->workout;

        return Inertia::render('Log/Show', ['workout' => $workout, 'log' => $log, 'modifiers' => $modifiers]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $Log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $Log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLogRequest  $request
     * @param  \App\Models\Log  $Log
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogRequest $request, Log $log)
    {
        $log->modifiers()->toggle($request->modifier_id);

        return back()->with('status', 'log-modifier-updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $Log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        $log->sets()->delete();
        $log->delete();

        return redirect()->action([WorkoutController::class, 'show'], $log->workout_id)->with('status', 'log-destroyed');

    }
}
