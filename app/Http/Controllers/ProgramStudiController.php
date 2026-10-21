<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Http\Resources\V1\ProgramStudiResource;
use App\Http\Requests\UpdateProgramStudiRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {

        return ProgramStudiResource::collection(
            ProgramStudi::query()->orderBy('kode_prodi')->get()
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {
        //
    }
}
