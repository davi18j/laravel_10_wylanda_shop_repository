<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Obtém uma consulta de todos os produtos, ordenados pelo ID mais recente, e carrega as imagens do produto
        $products = Product::latest('id')->with('product_image');

        // Verifica se há uma palavra-chave de pesquisa na requisição
        if (!empty($request->get('keyword'))) {
            // Adiciona uma cláusula where para filtrar os produtos pelo título que corresponde à palavra-chave
            $products = $products->where('title', 'like', '%' . $request->get('keyword') . '%');
        }

        // Pagina os resultados com limite de 5 produtos por página
        $products = $products->paginate(5);

        // Retorna a view 'admin.products.list' passando os produtos paginados como dados compactados
        return view('admin.products.list', compact('products'));
    }


    public function create()
    {
        // Obtém todas as categorias ordenadas por nome em ordem ascendente
        $categories = Category::orderBy('name', 'ASC')->get();

        // Obtém todas as marcas ordenadas por nome em ordem ascendente
        $brands = Brand::orderBy('name', 'ASC')->get();

        // Retorna a view 'admin.products.create' passando as categorias e marcas como dados compactados
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {

        // Definição das regras de validação
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes, No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        // Mensagens de erro personalizadas para as regras de validação
        $messages = [
            'title.required' => 'O campo título é obrigatório.',
            'slug.required' => 'O campo slug é obrigatório.',
            'slug.unique' => 'Este slug já está em uso.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico.',
            'sku.required' => 'O campo SKU é obrigatório.',
            'sku.unique' => 'Este SKU já está em uso.',
            'track_qty.required' => 'O campo track_qty é obrigatório.',
            'track_qty.in' => 'O valor de track_qty deve ser "Yes" ou "No".',
            'category.required' => 'O campo categoria é obrigatório.',
            'category.numeric' => 'A categoria deve ser um valor numérico.',
            'is_featured.required' => 'O campo é destaque é obrigatório.',
            'is_featured.in' => 'O valor do campo é destaque deve ser "Sim" ou "Não".',
            'qty.required' => 'O campo quantidade é obrigatório quando rastreamento de quantidade é definido como "Sim".',
            'qty.numeric' => 'A quantidade deve ser um valor numérico.',
        ];

        // Adiciona a regra de validação para 'qty' apenas se 'track_qty' for 'Yes'
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        // Cria o validador com as regras e mensagens personalizadas
        $validator = Validator::make($request->all(), $rules, $messages);

        // Verifica se a validação passa
        if ($validator->passes()) {
            // Cria uma nova instância de Produto
            $product = new Product();
            // Preenche os atributos do produto com os dados do request
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand_id;
            $product->is_featured = $request->is_featured;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            // Salva o produto no banco de dados
            $product->save();

            // Salva as imagens do produto
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_image_id) {
                    // Lógica para salvar as imagens do produto
                    foreach ($request->image_array as $temp_image_id) {


                        $manager = new ImageManager(new Driver());

                        $tempImageInfo = TempImage::find($temp_image_id);
                        $extArray = explode('.', $tempImageInfo->name);
                        $ext = last($extArray); // like jpg,gif,png etc
                        $productImage = new ProductImage();
                        $productImage->product_id = $product->id;
                        $productImage->image = 'NULL';
                        $productImage->save();

                        $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                        $productImage->image = $imageName;
                        $productImage->save();


                        // Large Image
                        $sourcePath = public_path() . '/temp/' . $tempImageInfo->name;
                        $destPath = public_path() . '/uploads/product/large/' . $imageName;
                        $image = $manager->read($sourcePath);
                        $image->resize(1400, 1400, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($destPath);
                        // Small Image
                        $destPath = public_path() . '/uploads/product/small/' .  $imageName;
                        $image = $manager->read($sourcePath);
                        $image->cover(300, 300);
                        $image->save($destPath);
                    }
                }
            }


            // Retorna uma resposta de sucesso
            $request->session()->flash('success', 'Produto adicionado com sucesso');
            return response([
                'status' => true,
                'message' => 'Produto adicionado com sucesso'
            ]);
        } else {
            // Retorna uma resposta com os erros de validação
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($product_id)
    {
        // Encontra o produto pelo ID fornecido
        $product = Product::find($product_id);

        // Encontra todas as subcategorias associadas à categoria do produto
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();

        // Obtém todas as categorias ordenadas por nome em ordem ascendente
        $categories = Category::orderBy('name', 'ASC')->get();

        // Obtém todas as marcas ordenadas por nome em ordem ascendente
        $brands = Brand::orderBy('name', 'ASC')->get();
        $relatedProducts = [];
        // fetch related products
        if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $productArray)->get();
        }

        // Encontra todas as imagens associadas ao produto
        $productImage = ProductImage::where('product_id', $product_id)->get();

        // Retorna a view 'admin.products.edit' passando as categorias, marcas, produto, subcategorias e imagens do produto como dados compactados
        return view('admin.products.edit', compact('categories', 'brands', 'product', 'subCategories', 'productImage','relatedProducts'));
    }
    public function update($product_id, Request $request)
    {
        // Busca o produto pelo ID
        $product = Product::find($product_id);

        // Verifica se o produto não foi encontrado
        if (empty($product)) {
            // Redireciona de volta para a página de listagem de produtos com uma mensagem de erro
            return redirect()->route('products.index')->with('error', 'Registro não encontrado');
        }

        // Regras de validação para os campos do formulário
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' .  $product->id . ',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' .  $product->id . ',id',
            'track_qty' => 'required|in:Yes, No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        // Mensagens de erro personalizadas para as regras de validação
        $messages = [
            'title.required' => 'O campo título é obrigatório.',
            'slug.required' => 'O campo slug é obrigatório.',
            'slug.unique' => 'Este slug já está em uso.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico.',
            'sku.required' => 'O campo SKU é obrigatório.',
            'sku.unique' => 'Este SKU já está em uso.',
            'track_qty.required' => 'O campo de rastreamento de quantidade é obrigatório.',
            'track_qty.in' => 'O valor do campo de rastreamento de quantidade deve ser "Sim" ou "Não".',
            'category.required' => 'O campo categoria é obrigatório.',
            'category.numeric' => 'A categoria deve ser um valor numérico.',
            'is_featured.required' => 'O campo é destaque é obrigatório.',
            'is_featured.in' => 'O valor do campo é destaque deve ser "Sim" ou "Não".',
        ];

        // Adiciona uma regra de validação adicional se o campo de rastreamento de quantidade for "Sim"
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        // Executa a validação dos dados recebidos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Se a validação passar, atualiza os dados do produto
        if ($validator->passes()) {
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand_id;
            $product->is_featured = $request->is_featured;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            $product->related_products = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';
            $product->save();

            // Adiciona uma mensagem de sucesso à sessão
            $request->session()->flash('success', 'Produto editado com sucesso');

            // Retorna uma resposta JSON indicando o sucesso da atualização
            return response([
                'status' => true,
                'message' => 'Produto editado com sucesso'
            ]);
        } else {
            // Se a validação falhar, retorna uma resposta JSON com os erros de validação
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        // Busca o produto pelo ID
        $product = Product::find($id);

        // Verifica se o produto não foi encontrado
        if (empty($product)) {
            // Define uma mensagem de erro para a sessão
            $request->session()->flash('error', 'Product not found');

            // Retorna uma resposta JSON indicando que o produto não foi encontrado
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        // Busca todas as imagens relacionadas ao produto
        $productImages = ProductImage::where('product_id', $id)->get();

        // Verifica se existem imagens relacionadas ao produto
        if (!empty($productImages)) {
            // Itera sobre cada imagem e exclui os arquivos correspondentes
            foreach ($productImages as $productImage) {
                File::delete(public_path('uploads/product/large/' . $productImage->image));
                File::delete(public_path('uploads/product/small/' . $productImage->image));
            }

            // Exclui todas as imagens relacionadas ao produto do banco de dados
            ProductImage::where('product_id', $id)->delete();
        }

        // Exclui o produto do banco de dados
        $product->delete();

        // Define uma mensagem de sucesso para a sessão
        $request->session()->flash('success', 'Product deleted successfully');

        // Retorna uma resposta JSON indicando que o produto foi excluído com sucesso
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
    public function getProducts(Request $request)
    {
        $tempProduct = [];
        if ($request->term != "") {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();
            if ($products != null) {
                foreach ($products as  $product) {
                    $tempProduct[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }
        return response()->json(
            [
                'tags' => $tempProduct,
                'status' => true
            ]
        );
    }
}
