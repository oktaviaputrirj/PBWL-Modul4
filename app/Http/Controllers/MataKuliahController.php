<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;

use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;
use App\Http\Resources\V1\MataKuliahResource;
use Illuminate\Http\Response;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::with('programStudi')
            ->orderBy('kode_mk')
            ->paginate(10);

        return MataKuliahResource::collection($mataKuliahs);
    }

    public function store(StoreMataKuliahRequest $request)
    {
        $mataKuliah = MataKuliah::create(
            $request->validated()
        );

        $mataKuliah->load('programStudi');

        return (new MataKuliahResource($mataKuliah))
            ->additional([
                'message' => 'Mata kuliah berhasil ditambahkan.'
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(MataKuliah $mataKuliah): MataKuliahResource
    {
        return new MataKuliahResource(
            $mataKuliah->load('programStudi')
        );
    }

    public function update(
        UpdateMataKuliahRequest $request,
        MataKuliah $mataKuliah
    ): MataKuliahResource {
        $mataKuliah->update($request->validated());

        $mataKuliah->load('programStudi');

        return (new MataKuliahResource($mataKuliah))
            ->additional([
                'message' => 'Mata kuliah berhasil diperbarui.'
            ]);
    }

    public function destroy(MataKuliah $mataKuliah): Response
    {
        $mataKuliah->delete();

        return response()->noContent();
    }
}