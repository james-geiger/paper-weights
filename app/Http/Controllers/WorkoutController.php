<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use Illuminate\Http\Request;
use App\Models\Note;

use Illuminate\Support\Facades\DB;

use App\Models\Workout;
use Inertia\Inertia;

use Auth;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

use Illuminate\Support\Facades\Log as Logger;

class WorkoutController extends Controller
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
    public function index(Request $request)
    {

        $today = CarbonImmutable::today($request->user()->timezone);

        if ($request->query('date')) {
            $base = CarbonImmutable::parse($request->query('date'));
        } else {
            $base = $today;
        }
        
        $start = $base->startOfWeek();
        $end = $base->endOfWeek();
        $nextWeek = $base->endOfWeek()->addDay();
        $prevWeek = $base->startOfWeek()->subDay();

        $workouts = Workout::AuthUser()->where('date', '<=', $end)->where('date', '>=', $start)->orderBy('date', 'desc')->get();

        $days = [];

        for ($i=0; $i < 7; $i++) { 
            $d = $start->addDays($i)->format('Y-m-d');
            array_push($days, ['date' => $d, 'isToday' => $today->isSameDay($start->addDays($i)),'hasWorkout' => $workouts->contains('date', $d) ]);
        }

        return Inertia::render('Workout/Index', ['workouts' => $workouts, 'days' => $days, 'dates' => ['today' => $today, 'nextWeek' => $nextWeek, 'prevWeek' => $prevWeek]]);
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
     * @param  \App\Http\Requests\StoreWorkoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkoutRequest $request)
    {
        $dt = new Carbon();

        $workout = Workout::create([
            'user_id' => Auth::user()->id,
            'name' => 'New Workout '.$dt->toFormattedDateString(),
            'date' => $dt->toDateString()
        ]);

        $logs = $workout->logs->sortBy([
            ['order', 'asc']
        ]);

        return Inertia::render('Workout/Show', ['workout' => $workout, 'logs' => $logs]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workout  $Workout
     * @return \Illuminate\Http\Response
     */
    public function show(Workout $workout)
    {
        $logs = $workout->logs->loadSum('sets', 'sets')->loadSum('sets', 'reps')->sortBy([
            ['order', 'asc']
        ]);

        $details = DB::table('workouts')
            ->where('workouts.id', '=', $workout->id)
            ->join('logs', 'logs.workout_id', '=', 'workouts.id')
            ->join('sets', 'sets.log_id', '=', 'logs.id')
            ->join('exercises', 'exercises.id', '=', 'logs.exercise_id')
            ->join('exercise_muscle', 'exercise_muscle.exercise_id', '=', 'exercises.id')
            ->join('muscles', 'exercise_muscle.muscle_id', '=', 'muscles.id')
            ->join('muscle_groups', 'muscles.muscle_group_id', '=', 'muscle_groups.id')
            ->groupBy('muscle_groups.name', 'muscles.name', 'exercise_muscle.type')
            ->selectRaw(
                'COUNT(DISTINCT(logs.id)) as count,
                SUM(sets.weight * sets.reps * sets.sets) as total_volume,
                SUM(sets.sets) as total_sets,
                SUM(sets.weight) as total_weight,
                SUM(sets.reps * sets.sets) as total_reps,
                muscle_groups.name AS group_name,
                muscles.name,
                exercise_muscle.type'
            )
            ->get()
            ->groupBy(['group_name', 'name']);


        return Inertia::render('Workout/Show', ['workout' => $workout, 'logs' => $logs, 'details' => $details ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workout  $Workout
     * @return \Illuminate\Http\Response
     */
    public function edit(Workout $workout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkoutRequest  $request
     * @param  \App\Models\Workout  $Workout
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkoutRequest $request, Workout $workout)
    {
        $validated = $request;

        $workout->name = $request->name;
        $workout->date = $request->date;
        $workout->time = $request->time;

        $workout->save();

        return redirect()->action([WorkoutController::class, 'show'], $workout->id)->with('status', 'workout-updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workout  $Workout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workout $workout)
    {
        $workout->sets()->delete();
        $workout->logs()->delete();
        $workout->delete();

        return redirect()->action([WorkoutController::class, 'index']);
    }


    public function store_note(Request $request, Workout $workout)
    {

        $note = Note::updateOrCreate(
            [ 'notable_type' => 'App\\Models\\Workout', 'notable_id' => $workout->id ],
            [ 'body' => $request->body ]
        );

        return response($note);
    }
}
