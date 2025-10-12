<?php

namespace App\Http\Controllers;

use App\Http\Requests\GdtRequest;
use App\Models\Guindaste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class GdtController extends Controller
{
        public function store(GdtRequest $request)
        {
            DB::beginTransaction();

            try {
                Guindaste::create($request->validated());

                DB::commit();

                return Redirect::route('wind-config')
                    ->with('success', 'Guindaste cadastrado com sucesso!');

            } catch (\Exception $e) {
                DB::rollBack();

                Log::error('Erro ao salvar guindaste: ' . $e->getMessage());

                return Redirect::back()
                    ->with('error', 'Ocorreu um erro ao salvar. Por favor, tente novamente.');
            }
        }

        public function create()
        {
            return inertia('#');
        }

        public function edit(Guindaste $guindaste)
        {
            // Return an Inertia page with the guindaste data for editing
            return inertia('EditGuin', [
                'guindaste' => $guindaste,
            ]);
        }

        public function destroy(Guindaste $guindaste)
        {
            DB::beginTransaction();
            try {
                $guindaste->delete();

                DB::commit();

                return Redirect::route('wind-config')
                    ->with('success', 'Guindaste deletado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro ao deletar o guindaste: ' . $e->getMessage());
                return Redirect::back()
                    ->with('error', 'Erro ao deletar o guindaste.');
            }
        }

        public function update(GdtRequest $request, Guindaste $guindaste)
        {
            DB::beginTransaction();
            try {
                $guindaste->update($request->validated());

                DB::commit();

                return Redirect::route('wind-config')
                    ->with('success', 'Guindaste atualizado com sucesso!');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro ao atualizar guindaste: ' . $e->getMessage());
                return Redirect::back()
                    ->with('error', 'Ocorreu um erro ao atualizar. Por favor, tente novamente.');
            }
        }
}
