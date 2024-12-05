<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Policies\OrderBelongsUserPolicy;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = $this->orderService->getAll();
            return response()->json($orders);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
            $orderCreated = $this->orderService->create($request);    
            
            DB::commit();
            return response()->json(['message' => 'Pedido cadastrado com sucesso', 'order' => $orderCreated], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {

            $order = $this->orderService->findOne($order->id);

            $userAuthorize = Auth::user();
            $this->validarOrderUser($userAuthorize, $order);

            if (!$order) return response()->json(['error' => 'Pedido não encontrado'], 404);

            return response()->json($order);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = $this->orderService->findOne($id);
            if (!$order) return response()->json(['error' => 'Pedido nao encontrado'], 404);

            $userAuthorize = Auth::user();
            $this->validarOrderUser($userAuthorize, $order);

            $this->orderService->update($order->id, (object) $request->toArray());    
            DB::commit();

            return response()->json(['message' => 'Pedido atualizado com sucesso'], 204);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            $order = $this->orderService->findOne($order->id);
            if (!$order) return response()->json(['error' => 'Pedido não encontrado'], 404);

            $userAuthorize = Auth::user();
            $this->validarOrderUser($userAuthorize, $order);

            $this->orderService->delete($order->id);    
            DB::commit();
            return response()->json(null, 204);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = $this->orderService->findOne($id);
            if (!$order) return response()->json(['error' => 'Pedido não encontrado'], 404);
            
            $userAuthorize = Auth::user();
            $this->validarOrderUser($userAuthorize, $order);
            
            $this->orderService->updateStatus($order->id, $request->status);    
           
            DB::commit();

            return response()->json(['message' => 'Pedido atualizado com sucesso'], 204);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function validarOrderUser($userAuthorize, $order){
        $policy = new OrderBelongsUserPolicy();
        if(!$policy->view($userAuthorize, $order))
            throw new Exception('Não autorizado, esse pedido não pertence ao usuário');
    }
}
