<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subCategoria = SubCategory::select('sub_categories.*', 'categories.name as categoyName')
            ->latest('sub_categories.id')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        if (!empty($request->get('keyword'))) {

            $subCategoria = $subCategoria->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
            $subCategoria = $subCategoria->orWhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subCategoria = $subCategoria->paginate(5);
        return view('admin.sub_category.list', compact('subCategoria'));
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.sub_category.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:sub_categories',
                'category' => 'required',
                'status' => 'required'
            ],
            [
                'name.required' => 'O campo nome da categória é obrigatório.',
                'slug.required' => 'O campo slug(nome alternativo) é obrigatório.',
                'slug.unique' => 'O slug já está em uso. Por favor, escolha outro.',
                'category.required' => 'O campo id da categoria é obrigatório.',
                'status.required' => 'O campo status da categoria é obrigatório.',
            ]
        );
        if ($validator->passes()) {
            $subcategory = new SubCategory();
            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->status = $request->status;
            $subcategory->showHome = $request->showHome;
            $subcategory->category_id = $request->category;
            $subcategory->save();
            $request->session()->flash('success', 'sub categoria adiconada com sucesso');
            return response([
                'status' => true,
                'message' => 'sub categoria adiconada com sucesso'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($subCategoryId, Request $request)
    {
        $subCategory = SubCategory::find($subCategoryId);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Registro nao encotrado');
            return redirect()->route('sub-categories.index');
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.sub_category.edit', compact('subCategory', 'categories'));
    }
    public function update($subCategoryId, Request $request)
    {
        $subCategory = SubCategory::find($subCategoryId);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Registro nao encotrado');
            return response([
                'status' => false,
                'notFound' => true
            ]);
            return redirect()->route('sub-categories.index');
        }
        $validator =  Validator::make(
            
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id . ',id',
                'category' => 'required',
                'status' => 'required'
            ],
            [
                'name.required' => 'O campo nome da Sub categória é obrigatório.',
                'slug.required' => 'O campo slug(nome alternativo) é obrigatório.',
                'slug.unique' => 'O slug já está em uso. Por favor, escolha outro.',
                'category.required' => 'O campo id da Sub categoria é obrigatório.',
                'status.required' => 'O campo status da Sub categoria é obrigatório.',
            ]
        );
        if ($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();
            $request->session()->flash('success', 'sub categoria editada com sucesso');
            return response([
                'status' => true,
                'message' => 'Sub categoria editada com sucesso'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($subcategoryId, Request $request)
    {
       $subCategory = SubCategory::find($subcategoryId);
       if (empty($subCategory)) {
 
          $request->session()->flash('error', 'Sub Categoria não entrada');
          // Retornar erros de validação em resposta JSON
          return response()->json([
             'status' => false,
             'message' => 'Sub Categoria não entrada'
          ]);
       }
       $subCategory->delete();
       // Mostrar mensagem de sucesso e retornar resposta JSON
       $request->session()->flash('success', 'Sub Categoria deletada com sucesso');
       // Retornar erros de validação em resposta JSON
       return response()->json([
          'status' => true,
          'message' => 'Sub Categoria deletada com sucesso'
       ]);
    }
}
