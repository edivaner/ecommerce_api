<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DTO\stock\CreateStockDTO;
use App\DTO\stock\UpdateStockDTO;
use Exception;

class StockController extends Controller
{

    public function __construct(
        protected StockService $stockService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $stock = $this->stockService->getAll();

            if (count($stock) == 0) {
                return response()->json(['message' => 'Nenhum estoque encontrado'], 404);
            }

            return response()->json([$stock]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os estoques', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $stock = $this->stockService->findOne($id);
            if (!$stock) return response()->json(['message' => 'Estoque não encontrado.'], 404);

            $stock = $this->stockService->update(UpdateStockDTO::makeFromRequest($request, $id));

            DB::commit();

            return response()->json(['message' => 'Estoque atualizado com sucesso'], 201);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao atualizar o estoque', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
