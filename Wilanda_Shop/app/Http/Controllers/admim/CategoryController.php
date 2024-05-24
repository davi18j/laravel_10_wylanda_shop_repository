<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
   public function index(Request $request)
   {
      $categoria = Category::latest('id');
      if (!empty($request->get('keyword'))) {

         $categoria = $categoria->where('name', 'like', '%' . $request->get('keyword') . '%');
      }
      $categoria = $categoria->paginate(5);
      return view('admin.category.list', compact('categoria'));
   }

   public function create()
   {
      return view('admin.category.create');
   }

   /**
    * Armazena uma nova categoria.
    * 
    * Realiza a validação da requisição, cria uma nova categoria,
    * salva a imagem da categoria, se fornecida, e retorna uma
    * resposta JSON indicando o status da operação.
    *
    * @param Request $request Os dados da requisição.
    * @return \Illuminate\Http\JsonResponse
    */
   public function store(Request $request)
   {
      // Validar a requisição
      $validator = $this->validateRequest($request);

      // Se a validação passar
      if ($validator->passes()) {
         // Criar uma nova categoria
         $category = $this->createCategory($request);

         // Salvar a imagem da categoria, se existir
         $this->saveCategoryImage($request, $category, null);

         // Mostrar mensagem de sucesso e retornar resposta JSON
         $request->session()->flash('success', 'Categoria adicionada com sucesso');
         return response()->json([
            'status' => true,
            'message' => 'Categoria adicionada com sucesso'
         ]);
      } else { // Se a validação falhar
         // Retornar erros de validação em resposta JSON
         return response()->json([
            'status' => false,
            'errors' => $validator->errors()
         ]);
      }
   }



   public function edit($categoryId, Request $request)
   {
      $category = Category::find($categoryId);
      if (empty($category)) {
         return redirect()->route('categories.index');
      }
      return view('admin.category.edit', compact('category'));
   }

   public function update($categoryId, Request $request)
   {
      $category = Category::find($categoryId);
      if (empty($category)) {
         return response()->json(
            [
               'status' => false,
               'notFound' => true,
               'message' => 'Categoria não encontrada'
            ]
         );
      }
      $validator =  Validator::make(
         $request->all(),
         [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id . ',id',
         ],
         [
            'name.required' => 'O campo nome da categória é obrigatório.',
            'slug.required' => 'O campo slug(nome alternativo) é obrigatório.',
            'slug.unique' => 'O slug já está em uso. Por favor, escolha outro.',
         ]
      );
      // Se a validação passar
      if ($validator->passes()) {
         // Criar uma nova categoria
         $category->name = $request->name;
         $category->slug = $request->slug;
         $category->status = $request->status;
         $category->showHome = $request->showHome;
         // Salvar a categoria no banco de dados
         $category->save();

         $oldImage = $category->image;
         // Salvar a imagem da categoria, se existir
         $this->saveCategoryImage($request, $category, $oldImage);

         // Mostrar mensagem de sucesso e retornar resposta JSON
         $request->session()->flash('success', 'Categoria editada com sucesso');
         return response()->json([
            'status' => true,
            'message' => 'Categoria editada com sucesso'
         ]);
      } else { // Se a validação falhar
         // Retornar erros de validação em resposta JSON
         return response()->json([
            'status' => false,
            'errors' => $validator->errors()
         ]);
      }
   }
   public function destroy($categoryId, Request $request)
   {
      $category = Category::find($categoryId);
      if (empty($category)) {

         $request->session()->flash('error', 'Categoria não entrada');
         // Retornar erros de validação em resposta JSON
         return response()->json([
            'status' => false,
            'message' => 'Categoria não entrada'
         ]);
      }
      File::delete(public_path() . '/uploads/category/thumb/' . $category->image);
      File::delete(public_path() . '/uploads/category/' . $category->image);

      $category->delete();
      // Mostrar mensagem de sucesso e retornar resposta JSON
      $request->session()->flash('success', 'Categoria deletada com sucesso');
      // Retornar erros de validação em resposta JSON
      return response()->json([
         'status' => true,
         'message' => 'Categoria deletada com sucesso'
      ]);
   }

   /**====================================================================== */
   /**
    * Valida os dados da requisição para armazenar uma categoria.
    *
    * @param Request $request Os dados da requisição.
    * @return \Illuminate\Contracts\Validation\Validator
    */
   private function validateRequest(Request $request)
   {
      // Realizar a validação dos dados da requisição
      return  Validator::make(
         $request->all(),
         [
            'name' => 'required',
            'slug' => 'required|unique:categories',
         ],
         [
            'name.required' => 'O campo nome da categória é obrigatório.',
            'slug.required' => 'O campo slug(nome alternativo) é obrigatório.',
            'slug.unique' => 'O slug já está em uso. Por favor, escolha outro.',
         ]
      );
   }

   /**
    * Cria uma nova categoria com os dados fornecidos na requisição.
    *
    * @param Request $request Os dados da requisição.
    * @return Category A categoria criada.
    */
   private function createCategory(Request $request)
   {
      // Criar uma nova instância de Categoria
      $category = new Category();
      // Atribuir valores recebidos da requisição aos campos correspondentes
      $category->name = $request->name;
      $category->slug = $request->slug;
      $category->status = $request->status;
      $category->showHome = $request->showHome;
      // Salvar a categoria no banco de dados
      $category->save();

      return $category;
   }

   /**
    * Salva a imagem associada à categoria, se fornecida na requisição.
    *
    * @param Request $request Os dados da requisição.
    * @param Category $category A categoria associada à imagem.
    * @return void
    */
   private function saveCategoryImage(Request $request, $category, $oldImage = null)
   {
      // Verificar se há uma imagem a ser salva
      if (!empty($request->image_id)) {
         // Encontrar a imagem temporária
         $tempImage = TempImage::find($request->image_id);
         // Obter a extensão da imagem
         $extArray = explode('.', $tempImage->name);
         $ext = last($extArray);

         if ($oldImage != null) {

            // Nomear a nova imagem com base no ID da categoria
            $newImageName = $category->id . '-' . time() . '.' . $ext;
            // Definir o caminho de origem e destino da imagem
            $sourcePath = public_path() . '/temp/' . $tempImage->name;
            $destinationPath = public_path() . '/uploads/category/' . $newImageName;
            // Copiar a imagem para o diretório de uploads
            File::copy($sourcePath, $destinationPath);

            // Definir o caminho de destino da miniatura da imagem
            $destinationThumbPath = public_path() . '/uploads/category/thumb/' . $newImageName;

            // Redimensionar e salvar a imagem
            $this->resizeAndSaveImage($sourcePath, $destinationThumbPath);
            File::delete(public_path() . '/uploads/category/thumb/' . $oldImage);
            File::delete(public_path() . '/uploads/category/' . $oldImage);
         } else {
            // Nomear a nova imagem com base no ID da categoria
            $newImageName = $category->id . '.' . $ext;
            // Definir o caminho de origem e destino da imagem
            $sourcePath = public_path() . '/temp/' . $tempImage->name;
            $destinationPath = public_path() . '/uploads/category/' . $newImageName;
            // Copiar a imagem para o diretório de uploads
            File::copy($sourcePath, $destinationPath);

            // Definir o caminho de destino da miniatura da imagem
            $destinationThumbPath = public_path() . '/uploads/category/thumb/' . $newImageName;

            // Redimensionar e salvar a imagem
            $this->resizeAndSaveImage($sourcePath, $destinationThumbPath);
         }
         // Atribuir o nome da imagem à categoria e salvá-la no banco de dados    
         $category->image = $newImageName;
         $category->save();
      }
   }

   /**
    * Redimensiona e salva uma imagem no caminho especificado.
    *
    * @param string $sourcePath O caminho da imagem original.
    * @param string $destinationPath O caminho onde a imagem redimensionada será salva.
    * @return void
    */
   private function resizeAndSaveImage($sourcePath, $destinationPath)
   {
      // Criar uma instância do gerenciador de imagens
      $manager = new ImageManager(new Driver());
      // Ler a imagem original
      $image = $manager->read($sourcePath);
      // Redimensionar a imagem
      $image->resize(450, 600);
      // Salvar a imagem redimensionada
      $image->save($destinationPath);
   }
}
