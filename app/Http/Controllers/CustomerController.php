<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DTO\customer\CreateCustomerDTO;
use App\DTO\customer\UpdateCustomerDTO;
use Exception;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected CustomerService $customerService
    ) {
    }
    
    public function index()
    {
        try {
            $customer = $this->customerService->getAll();

            return response()->json([$customer]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os cliente', 'error' => $e->getMessage()], 500);
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

            if(!isset($request->address['neighborhood']) OR $request->address['neighborhood'] == '') {
                throw new \Exception('O campo neighborhood é obrigatório.');
            }
    
            $request->address = [
                'street' => isset($request->address['street']) ? $request->address['street'] : null,
                'neighborhood' => isset($request->address['neighborhood']) ? $request->address['neighborhood'] : null,
                'number' => isset($request->address['number']) ? $request->address['number'] : null,
                'city' => isset($request->address['city']) ? $request->address['city'] : null,
                'reference' => isset($request->address['reference']) ? $request->address['reference'] : null,
                // 'complement' => isset($request->address['complement']) ? $request->address['complement'] : null,
                // 'state' => isset($request->address['state']) ? $request->address['state'] : null,
                // 'zip_code' => isset($request->address['zip_code']) ? $request->address['zip_code'] : null
            ];

            $customerCreated = $this->customerService->create(CreateCustomerDTO::makeFromRequest($request));

            DB::commit();

            return response()->json(['message' => 'Cliente cadastrado com sucesso', 'customer' => $customerCreated], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o cliente', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $customer = $this->customerService->findOne($id);
            if (!$customer) return response()->json(['message' => 'Não foi possível encontrar esse cliente'], 404);

            return response()->json([$customer]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível encontrar esse cliente', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
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

            $customer = $this->customerService->findOne($id);
            if (!$customer) return response()->json(['message' => 'Cliente não encontrado.'], 404);

            $customer = $this->customerService->update(UpdateCustomerDTO::makeFromRequest($request, $id));

            DB::commit();

            return response()->json(['message' => 'Cliente atualizado com sucesso'], 201);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao atualizar o cliente', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $customer = $this->customerService->findOne($id);
            if (!$customer) return response()->json(['error' => 'Não foi encontrado este cliente para ser excluido.'], 404);

            $this->customerService->delete($id);

            DB::commit();
            return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar esse cliente', 'error' => $e->getMessage()], 500);
        }
    }
}