<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DTO\department\CreateDepartmentDTO;
use App\DTO\department\UpdateDepartmentDTO;
use Exception;

class DepartmentController extends Controller
{

    public function __construct(
        protected DepartmentService $departmentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $department = $this->departmentService->getAll();

            if (count($department) == 0) {
                return response()->json(['message' => 'Nenhum departamento encontrado'], 404);
            }

            return response()->json([$department]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os departamentos', 'error' => $e->getMessage()], 500);
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

            if (!isset($request->name) OR $request->name == '') {
                throw new \Exception('O campo nome é obrigatório.');

            }

            $departmentCreated = $this->departmentService->create(CreateDepartmentDTO::makeFromRequest($request));

            DB::commit();

            return response()->json(['message' => 'Departamento cadastrado com sucesso', 'department' => $departmentCreated], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Erro ao cadastrar o departamento', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
