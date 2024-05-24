<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request)
    {
       $brands = Brand::latest('id');
       if (!empty($request->get('keyword'))) {
 
          $brands = $brands->where('name', 'like', '%' . $request->get('keyword') . '%');
       }
       $brands = $brands->paginate(5);
       return view('admin.brand.list', compact('brands'));
    }
    public function create()
    {
       return view('admin.brand.create');
    }
    public function store(Request $request)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:brands',
                'status' => 'required'
            ],
            [
                'name.required' => 'O campo nome da marca é obrigatório.',
                'slug.required' => 'O campo slug(nome alternativo) é obrigatório.',
                'slug.unique' => 'O slug já está em uso. Por favor, escolha outro.',
                'status.required' => 'O campo status da marca é obrigatório.',
            ]
        );
        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $request->session()->flash('success', 'Marca adiconada com sucesso');
            return response([
                'status' => true,
                'message' => 'Marca adiconada com sucesso'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($brandId, Request $request)
    {
       $brand = Brand::find($brandId);
       if (empty($brand)) {
          return redirect()->route('brands.index');
       }
       return view('admin.brand.edit', compact('brand'));
    }

    public function update($brandId, Request $request)
    {
       $brand = Brand::find($brandId);
        if (empty($brand)) {
            $request->session()->flash('error', 'Registro nao encotrado');
            return response([
                'status' => false,
                'notFound' => true
            ]);
            //return redirect()->route('sub-categories.index');
        }
        $validator =  Validator::make(
            
            $request->all(),
            [
                'name' => 'required',
                'slug' => 'required|unique:brands,slug,' .$brand->id . ',id',
                'status' => 'required'
            ],
            [
                'name.required' => 'O campo nome da marca é obrigatório.',
                'slug.required' => 'O campo slug(nome alternativo) é obrigatório.',
                'slug.unique' => 'O slug já está em uso. Por favor, escolha outro.',
                'status.required' => 'O campo status da marca é obrigatório.',
            ]
        );
        if ($validator->passes()) {

            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
            $request->session()->flash('success', 'Marca editada com sucesso');
            return response([
                'status' => true,
                'message' => 'Marca editada com sucesso'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($brandId, Request $request)
    {
      $brand = Brand::find($brandId);
       if (empty($brand)) {
 
          $request->session()->flash('error', 'Marca não entrada');
          // Retornar erros de validação em resposta JSON
          return response()->json([
             'status' => false,
             'message' => 'Sub Categoria não entrada'
          ]);
       }
      $brand->delete();
       // Mostrar mensagem de sucesso e retornar resposta JSON
       $request->session()->flash('success', 'Marca deletada com sucesso');
       // Retornar erros de validação em resposta JSON
       return response()->json([
          'status' => true,
          'message' => 'Marca deletada com sucesso'
       ]);
    }
}
