<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipamentoRequest;
use App\Models\Equipamento;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class EquipamentoController extends Controller
{
    public function index()
    {
        $equipamentos = Equipamento::orderBy('id', 'desc')->get();

        return Inertia::render('EquipamentoConfig', [
            'equipamentos' => $equipamentos,
        ]);
    }

    public function create()
    {
        return Inertia::render('CadastroEquip');
    }

    public function store(EquipamentoRequest $request): RedirectResponse
    {
        Equipamento::create($request->validated());

        // Redirect to the EquipamentoConfig page (compat sidebar)
        return redirect()->route('equipamento-config');
    }

    public function edit(Equipamento $equipamento)
    {
        return Inertia::render('EditEquip', [
            'equipamento' => $equipamento,
        ]);
    }

    public function update(EquipamentoRequest $request, Equipamento $equipamento): RedirectResponse
    {
        $equipamento->update($request->validated());

        return redirect()->route('equipamento-config');
    }

    public function destroy(Equipamento $equipamento): RedirectResponse
    {
        $equipamento->delete();

        return redirect()->route('equipamento-config');
    }
}
