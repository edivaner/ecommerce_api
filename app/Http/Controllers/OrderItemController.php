<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Services\OrderItemService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function __construct(
        private OrderItemService $orderItemService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $order = $this->orderItemService->getAll();

            return response()->json([$order]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os itens do pedido', 'error' => $e->getMessage()], 500);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idOrder)
    {
        try {
            $OrderItem = $this->orderItemService->findOne($idOrder); 
            if (!$OrderItem) return response()->json(['message' => 'Não foi possível encontrar esse pedido'], 404);

            return response()->json([$OrderItem]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível encontrar esse pedido', 'error' => $e->getMessage()], 500);
        }
    }

    public function showItens(string $idOrder, string $idProduct)
    {
        try {
            $OrderItem = $this->orderItemService->findOne($idOrder, $idProduct); 
            if (!$OrderItem) return response()->json(['message' => 'Não foi possível encontrar os itens desse pedido'], 404);

            return response()->json([$OrderItem]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível encontrar os itens desse pedido', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idOrder, string $idProduct)
    {
        try {
            DB::beginTransaction();

            $cartItem = $this->orderItemService->findOne($idOrder, $idProduct);
            if (!$cartItem) return response()->json(['error' => 'Não foi encontrado este item do pedido para ser excluido.'], 404);

            $this->orderItemService->delete($idOrder, $idProduct);

            DB::commit();
            return response()->json(['message' => 'Item do pedido deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar o item desse pedido', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateQuantity(Request $request, string $idOrder, string $idProduct)
    {
        try {
            DB::beginTransaction();

            $orderItem = $this->orderItemService->findOne($idOrder, $idProduct);
            if (!$orderItem) return response()->json(['error' => 'Não foi encontrado este item do carrinho para ser atualizado.'], 404);

            $orderItem = $this->orderItemService->updateQuantity($idOrder, $idProduct, $request->quantity);

            DB::commit();
            return response()->json(['message' => 'Item do pedido atualizado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível atualizar o item desse pedido', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateAddItem(Request $request) {
        try {
            DB::beginTransaction();

            // $product = $this->productService->findOne($request->idProduct);
            // if (!$product) return response()->json(['error' => 'Não foi encontrado este produto para ser adicionado no pedido.'], 404);
              
            if($request->idOrder) {
                $cartItemExistInCart = $this->orderItemService->findOne($request->idOrder, $request->idProduct);

                if ($cartItemExistInCart) {
                    $this->orderItemService->updateQuantity($request->idOrder, $request->idProduct, $request->quantity);

                    return response()->json(['message' => 'Item atualizado com sucesso'], 200);
                }
            }

            $this->orderItemService->updateAddItem($request->idOrder, $request->idProduct, $request->quantity);

            DB::commit();
            return response()->json(['message' => 'Item adicionado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível atualizar o item desse pedido', 'error' => $e->getMessage()], 500);
        }
    }
}
