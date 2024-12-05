<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Policies\OrderBelongsUserPolicy;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\ProductService;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private OrderItemService $orderItemService,
        private OrderService $orderService,
        private ProductService $productService
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
            $orderItem = $this->orderItemService->findOne($idOrder); 
            if (!$orderItem) return response()->json(['message' => 'Não foi possível encontrar esse pedido'], 404);

            $userAuthorize = Auth::user();
            $this->validarOrderItemUser($userAuthorize, $orderItem);


            return response()->json([$orderItem]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível encontrar esse pedido', 'error' => $e->getMessage()], 500);
        }
    }

    public function showItens(string $idOrder, string $idProduct)
    {
        try {
            $orderItem = $this->orderItemService->findOne($idOrder, $idProduct); 
            if (!$orderItem) return response()->json(['message' => 'Não foi possível encontrar os itens desse pedido'], 404);

            $userAuthorize = Auth::user();
            $this->validarOrderItemUser($userAuthorize, $orderItem);

            return response()->json([$orderItem]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível encontrar os itens desse pedido', 'error' => $e->getMessage()], 500);
        }
    }

    public function validarOrderItemUser($userAuthorize, $OrderItem){
        $policy = new OrderBelongsUserPolicy();
        $order = $this->orderService->findOne($OrderItem->order_id);
        if(!$policy->view($userAuthorize, $order))
            throw new Exception('Não autorizado, esse pedido não pertence ao usuário');
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

            $orderItem = $this->orderItemService->findOne($idOrder, $idProduct);
            if (!$orderItem) return response()->json(['error' => 'Não foi encontrado este item do pedido para ser excluido.'], 404);

            $userAuthorize = Auth::user();
            $this->validarOrderItemUser($userAuthorize, $orderItem);

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

            $userAuthorize = Auth::user();
            $this->validarOrderItemUser($userAuthorize, $orderItem);

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

            $product = $this->productService->findOne($request->idProduct);
            if (!$product) return response()->json(['error' => 'Não foi encontrado este produto para ser adicionado no pedido.'], 404);
              
            if($request->idOrder) {
                $orderItem = $this->orderItemService->findOne($request->idOrder, $request->idProduct);

                if ($orderItem) {
                    $userAuthorize = Auth::user();
                    $this->validarOrderItemUser($userAuthorize, $orderItem);

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
