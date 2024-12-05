<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CartService;
use App\DTO\cart\CreateCartDTO;
use App\DTO\cart\UpdateCartDTO;
use App\Policies\CartBelongsUserPolicy;
use App\Services\CartItemService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
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
            $cart = $this->cartService->getAll();

            return response()->json([$cart]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar este carrinho', 'error' => $e->getMessage()], 500);
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
        try {
            DB::beginTransaction();
            
            $request = (object) $request->toArray();
            $cartCreated = $this->cartService->create(CreateCartDTO::makeFromRequest($request));    
            
            DB::commit();

            return response()->json(['message' => 'Carrinho cadastrado com sucesso', 'cart' => $cartCreated], 201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o carrinho', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cart = $this->cartService->findOne($id);
            if (!$cart) return response()->json(['error' => 'Não foi possível encontrar esse carrinho'], 404);

            return response()->json([$cart], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível encontrar esse carrinho', 'error' => $e->getMessage()], 500);
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
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $cart = $this->cartService->findOne($id);
            if (!$cart) return response()->json(['error' => 'Não foi encontrado este carrinho para ser excluido.'], 404);

            $this->cartService->delete($id);

            DB::commit();
            return response()->json(['message' => 'Carrinho deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar esse carrinho', 'error' => $e->getMessage()], 500);
        }
    }

    public function validarCartPertenceUser($userAuthorize, $cart){
        $policy = new CartBelongsUserPolicy();
        if(!$policy->view($userAuthorize, $cart))
            throw new Exception('Não autorizado, esse pedido não pertence ao usuário');
    }
}
