<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        // Instância do gerenciador de imagens
        $manager = new ImageManager(new Driver());

        // Obtenção da imagem do request
        $image = $request->image;

        // Obtenção da extensão da imagem
        $ext = $image->getClientOriginalExtension();

        // Caminho de origem da imagem
        $sourcePath = $image->getPathName();

        // Criação de uma nova instância de ProductImage
        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL'; // Salvando temporariamente
        $productImage->save();

        // Geração de um nome único para a imagem
        $imageName = $request->product_id . $productImage->id . '-' . time() . '.' . $ext;
        $productImage->image = $imageName; // Atualizando o nome da imagem
        $productImage->save();

        // Large Image (imagem grande)
        $destPathLarge = public_path() . '/uploads/product/large/' . $imageName;
        $image = $manager->read($sourcePath);
        $image->resize(1400, 1400, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($destPathLarge);

        // Small Image (imagem pequena)
        $destPathSmall = public_path() . '/uploads/product/small/' . $imageName;
        $image = $manager->read($sourcePath);
        $image->cover(300, 300); // Ajuste para o tamanho desejado
        $image->save($destPathSmall);

        // Retorna uma resposta JSON indicando o sucesso e informações sobre a imagem
        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'ImagePath' => asset('uploads/product/small/' . $productImage->image),
            'message' => 'Image saved successfully'
        ]);
    }

    public function destroy(Request $request)
    {
        // Encontra a imagem do produto pelo ID
        $productImage = ProductImage::find($request->id);

        // Verifica se a imagem do produto não foi encontrada
        if (empty($productImage)) {
            // Retorna uma resposta JSON indicando que a imagem não foi encontrada
            return response()->json([
                'status' => false,
                'message' => 'Image not found'
            ]);
        }

        // Exclui as imagens do diretório
        File::delete(public_path('uploads/product/large/' . $productImage->image));
        File::delete(public_path('uploads/product/small/' . $productImage->image));

        // Exclui a imagem do produto do banco de dados
        $productImage->delete();

        // Retorna uma resposta JSON indicando que a imagem foi excluída com sucesso
        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}
