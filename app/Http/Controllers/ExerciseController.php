<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Log;
use Auth;

class ExerciseController extends Controller
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
     * @param  \App\Http\Requests\StoreExerciseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExerciseRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExerciseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store_quick(StoreExerciseRequest $request)
    {
        // Retrieve the validated input data
        $validated = $request;

        $exercise = Exercise::create([
            'name' => $validated->name,
            'user_id' => Auth::user()->id,
            'type_id' => 'acfe80a0-b16b-11ec-85d8-63abaa72c901'
        ]);

        $log = Log::create([
            'exercise_id' => $exercise->id,
            'workout_id' => $request->workout_id,
            'type_id' => $exercise->type_id,
            'order' => $request->order,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->action([LogController::class, 'show'], $log->id)->with('status', 'log-created');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exercise  $Exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Exercise $Exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exercise  $Exercise
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercise $Exercise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExerciseRequest  $request
     * @param  \App\Models\Exercise  $Exercise
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExerciseRequest $request, Exercise $Exercise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exercise  $Exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercise $Exercise)
    {
        //
    }

    public function search(Request $request)
    {

        if ($request-> q == '') {
           return [];
        }

        $exercises = Exercise::search($request->q)->query(fn ($query) => $query->where(function($query) {
            $query->where('user_id', Auth::user()->id)
                  ->orWhereNull('user_id');
            })->limit(15))->get();

        return $exercises;
    }
}
