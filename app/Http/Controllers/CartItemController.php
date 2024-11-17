<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CartItemService;

class CartItemController extends Controller
{
    public function __construct(
        private CartItemService $cartItensService
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cart = $this->cartItensService->getAll();

            return response()->json([$cart]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os itens do carrinho', 'error' => $e->getMessage()], 500);
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idCart, string $idProduct)
    {
        try {
            $cartItem = $this->cartItensService->findOne($idCart, $idProduct); 
            if (!$cartItem) return response()->json(['message' => 'Não foi possível encontrar os itens desse carrinho'], 404);

            return response()->json([$cartItem]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível encontrar os itens desse carrinho', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idCart, string $idProduct)
    {
        try {
            DB::beginTransaction();

            $cartItem = $this->cartItensService->findOne($idCart, $idProduct);
            if (!$cartItem) return response()->json(['error' => 'Não foi encontrado este item do carrinho para ser excluido.'], 404);

            $this->cartItensService->delete($idCart, $idProduct);

            DB::commit();
            return response()->json(['message' => 'Item do carrinho deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar o item desse carrinho', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateQuantity(Request $request, string $idCart, string $idProduct)
    {
        try {
            DB::beginTransaction();

            $cartItem = $this->cartItensService->findOne($idCart, $idProduct);
            if (!$cartItem) return response()->json(['error' => 'Não foi encontrado este item do carrinho para ser atualizado.'], 404);

            $cartItem = $this->cartItensService->updateQuantity($idCart, $idProduct, $request->quantity);

            DB::commit();
            return response()->json(['message' => 'Item do carrinho atualizado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível atualizar o item desse carrinho', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateAddItem(Request $request) {
        try {
            DB::beginTransaction();

            // $product = $this->productService->findOne($request->idProduct);
            // if (!$product) return response()->json(['error' => 'Não foi encontrado este produto para ser adicionado no carrinho.'], 404);
              
            if($request->idCart) {
                $cartItemExistInCart = $this->cartItensService->findOne($request->idCart, $request->idProduct);

                if ($cartItemExistInCart) {
                    $this->cartItensService->updateQuantity($request->idCart, $request->idProduct, $request->quantity);

                    return response()->json(['message' => 'Item atualizado com sucesso'], 200);
                }
            }

            $this->cartItensService->updateAddItem($request->idCart, $request->idProduct, $request->quantity);

            DB::commit();
            return response()->json(['message' => 'Item adicionado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível atualizar o item desse carrinho', 'error' => $e->getMessage()], 500);
        }
    }
}
