<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Modifier;
use App\Models\Exercise;
use App\Models\Unit;
use App\Models\Type;
use App\Models\Set;

use Illuminate\Support\Facades\Log as Logger;

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

        $exercise = Exercise::find($request->exercise_id);

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
     * @param  \App\Models\Log  $Log
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Log $log)
    {

        if ($request->user()->cannot('view', $log)) {
            abort(403);
        }

        $units = Unit::all();
        $types = Type::all();

        $log->loadCount('sets');
        $log->loadSum('sets', 'reps');

        $modifiers = Modifier::all();

        $workout = $log->workout;

        $prev_log = Log::where('workout_id', $log->workout_id)->where('order', $log->order - 1)->first();
        $next_log = Log::where('workout_id', $log->workout_id)->where('order', $log->order + 1)->first();

        $page = [
            'prev' => ($prev_log) ? route('logs.show', ['log' => $prev_log->id]) : null,
            'next' => ($next_log) ? route('logs.show', ['log' => $next_log->id]) : null,
        ];

        $last_log = Log::with('workout')
                        ->where('exercise_id', $log->exercise->id)
                        ->where('id', '<>', $log->id)
                        ->select('logs.*', \DB::raw('(SELECT date FROM workouts WHERE logs.workout_id = workouts.id ) as date'))
                        ->orderBy('date', 'desc')
                        ->withCount('sets')
                        ->withSum('sets', 'reps')
                        ->limit(1)
                        ->get();

        $one_rep_max = Set::join('logs', 'sets.log_id', '=', 'logs.id')
                        ->select(\DB::raw('(weight / ( 1.0278-0.0278 * reps )) as one_rep_max'))
                        ->where('exercise_id', $log->exercise_id)
                        ->withoutGlobalScopes()
                        ->orderBy('weight', 'desc')
                        ->orderBy('reps', 'asc')
                        ->limit(1)
                        ->get()
                        ->first()
                        ->only('one_rep_max')['one_rep_max'];

        $arr = [
            '60' => round($one_rep_max*0.6),
            '70' => round($one_rep_max*0.7),
            '80' => round($one_rep_max*0.8),
            '90' => round($one_rep_max*0.9),
            'one_rep_max' => round($one_rep_max*1)
        ];

        return Inertia::render('Log/Show', [
            'workout' => $workout,
            'log' => $log,
            'pagination' => $page,
            'last_log' => $last_log,
            'modifiers' => $modifiers,
            'units' => $units,
            'types' => $types,
            'one_rep_max' => $arr
        ]);

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
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {

        $logs = $request->reordered_logs;

        foreach ($logs as $key => $log) {
            $l = Log::find($log);
            $l->order = $key + 1;
            $l->save();
        }

        return back()->with('status', 'log-modifier-updated');
    }

    public function updateType(Request $request, Log $log)
    {
        if ($request->user()->cannot('view', $log)) {
            abort(403);
        }

        $log->type_id = $request->type['id'];

        $log->save();

        $log->sets()->delete();

        return redirect()->action([LogController::class, 'show'], $log->id)->with('status', 'log-type-updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $Log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Log $log)
    {
        if ($request->user()->cannot('delete', $log)) {
            abort(403);
        }

        $log->sets()->delete();
        $log->delete();

        return redirect()->action([WorkoutController::class, 'show'], $log->workout_id)->with('status', 'log-destroyed');

    }
}
