<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModifierRequest;
use App\Http\Requests\UpdateModifierRequest;
use App\Models\Modifier;

class ModifierController extends Controller
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
     * @param  \App\Http\Requests\StoreModifierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModifierRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modifier  $Modifier
     * @return \Illuminate\Http\Response
     */
    public function show(Modifier $Modifier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modifier  $Modifier
     * @return \Illuminate\Http\Response
     */
    public function edit(Modifier $Modifier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModifierRequest  $request
     * @param  \App\Models\Modifier  $Modifier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModifierRequest $request, Modifier $Modifier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modifier  $Modifier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modifier $Modifier)
    {
        //
    }
}
