<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DTO\product\CreateProductDTO;
use App\DTO\product\UpdateProductDTO;
use Exception;

class ProductController extends Controller
{

    public function __construct(
        protected ProductService $productService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $product = $this->productService->getAll();

            if (count($product) == 0) {
                return response()->json(['message' => 'Nenhum produto encontrado'], 404);
            }

            return response()->json([$product]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os produtos', 'error' => $e->getMessage()], 500);
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
            
            $request->price = str_replace(',', '.', $request->price);
            $request->price = number_format($request->price, 2, '.', '');

            $request->ean   = str_replace('.', '', $request->ean);
            $request->ean   = str_pad($request->ean, 13, "0", STR_PAD_LEFT); 
            
            if (!isset($request->description) OR $request->description == '') {
                throw new \Exception('O campo descricão é obrigatório.');

            } else if (!isset($request->ean) OR $request->ean == '') {
                // throw new \Exception('O campo ean é obrigatório.');
                // VER MELHOR FORMA DE LANCAR O ID DO PRODUTO NO EAN QUANDO EAN FOR VAZIO - PROVAVELMENTE NO ProductEloquentORM

            } else if (!is_numeric($request->ean)) {
                throw new \Exception('O campo ean aceita apenas números.');    

            } else if (strlen($request->ean) > 13) {
                $request->ean = substr($request->ean, -13); 

            } else if (!isset($request->price) OR $request->price == '') {
                throw new \Exception('O campo preço é obrigatório.');

            } else if (!is_numeric($request->price)) {
                throw new \Exception('O campo preço aceita apenas números.');

            } 

            $productCreated = $this->productService->create(CreateProductDTO::makeFromRequest($request));

            DB::commit();

            return response()->json(['message' => 'Produto cadastrado com sucesso', 'product' => $productCreated], 201);
            
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Erro ao cadastrar o produto', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
