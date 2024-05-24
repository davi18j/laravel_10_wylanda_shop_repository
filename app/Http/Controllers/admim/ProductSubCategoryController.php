<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Verifica se o parâmetro category_id foi enviado na requisição
        if (!empty($request->category_id)) {
            // Se o category_id estiver presente, busca as subcategorias correspondentes à categoria especificada
            $subCategories = SubCategory::where('category_id', $request->category_id)
                ->orderBy('name', 'ASC') // Ordena as subcategorias pelo nome em ordem ascendente
                ->get(); // Obtém as subcategorias
            
            // Retorna uma resposta JSON com as subcategorias encontradas
            return response()->json([
                'status' => true,
                'subCategories' => $subCategories
            ]);
        } else {
            // Se o category_id não estiver presente, retorna uma resposta JSON vazia
            return response()->json([
                'status' => true,
                'subCategories' => []
            ]);
        }
    }
    
}
