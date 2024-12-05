<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Services\StaffService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $staffService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $staff = $this->staffService->getAll();

            if (!$staff) return response()->json(['message' => 'Nenhum funcionário cadastrado'], 404);
            
            return response()->json([$staff]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os funcionários', 'error' => $e->getMessage()], 500);
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

            $auth = Auth::user();
            if (!$auth) throw new \Exception('Necessário login');
            if(($auth->role != 'admin')) throw new \Exception( 'Não autorizado. Você não pode criar funcionários');
            
            $request = (object) $request->toArray();

            if (!isset($request->address['neighborhood']) OR $request->address['neighborhood'] == '') {
                throw new \Exception('O campo neighborhood é obrigatório.');
            }

            $staffCreated = $this->staffService->create($request);

            DB::commit();

            return response()->json(['message' => 'Funcionário cadastrado com sucesso', 'funcionário' => $staffCreated], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o funcionário', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $auth = Auth::user();
            if (!$auth) throw new \Exception('Necessário login');
            if(($auth->id != $id) AND ($auth->role != 'admin')) throw new \Exception( 'Não autorizado. Você não pode visualizar esse funcionário');

            $staff = $this->staffService->findOne($id);
            if (!$staff) return response()->json(['message' => 'Não foi possível encontrar esse funcionário'], 404);

            return response()->json([$staff]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível encontrar esse funcionário', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
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
            $auth = Auth::user();
            if (!$auth) throw new \Exception('Necessário login');
            if(($auth->id != $id) AND ($auth->role != 'admin')) throw new \Exception( 'Não autorizado. Você não pode atualizar esse funcionário');
            
            $staff = $this->staffService->findOne($id);
            if (!$staff) return response()->json(['message' => 'Funcionário não encontrado.'], 404);

            $staff = $this->staffService->update($request, $id);

            DB::commit();

            return response()->json(['message' => 'Funcionário atualizado com sucesso'], 201);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao atualizar o funcionário', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            if (!$auth) throw new \Exception('Necessário login');
            if(($auth->id != $id) AND ($auth->role != 'admin')) throw new \Exception( 'Não autorizado. Você não pode deletar esse funcionário');
            
            $staff = $this->staffService->findOne($id);
            if (!$staff) return response()->json(['error' => 'Não foi encontrado este funcionário para ser excluido.'], 404);

            $this->staffService->delete($id);

            DB::commit();
            return response()->json(['message' => 'Funcionário deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar esse funcionário', 'error' => $e->getMessage()], 500);
        }
    }
}
