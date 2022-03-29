<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;

class EquipmentController extends Controller
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
     * @param  \App\Http\Requests\StoreEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $Equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $Equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipment  $Equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $Equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEquipmentRequest  $request
     * @param  \App\Models\Equipment  $Equipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentRequest $request, Equipment $Equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $Equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $Equipment)
    {
        //
    }
}
