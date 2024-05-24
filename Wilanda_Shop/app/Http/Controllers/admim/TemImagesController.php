<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TemImagesController extends Controller
{public function create(Request $request)
  {
      // Verifica se uma imagem foi enviada na requisição
      $image = $request->image;
      if (!empty($image)) {
          // Obtém a extensão da imagem
          $extension = $image->getClientOriginalExtension();
          
          // Gera um novo nome único para a imagem
          $newName = time() . '.' . $extension;
          
          // Cria uma nova instância de TempImage e salva o nome da imagem temporária
          $tempImage = new TempImage();
          $tempImage->name = $newName;
          $tempImage->save();
          
          // Move a imagem para o diretório temporário
          $image->move(public_path() . '/temp', $newName);
          
          // Caminho da imagem original e do thumbnail
          $sourcePath = public_path().'/temp/'. $newName;
          $destPath = public_path().'/temp/thumb/'. $newName;
          
          // Instância do gerenciador de imagens
          $manager = new ImageManager(new Driver());
  
          // Ler a imagem original
          $image = $manager->read($sourcePath);
          // Redimensionar e cortar a imagem para caber dentro de uma área de 300x275
          $image->cover(300, 275);
          // Salvar a imagem redimensionada como um thumbnail
          $image->save($destPath);
  
          // Retorna uma resposta JSON com o status, o ID da imagem temporária, o caminho do thumbnail e uma mensagem de sucesso
          return response()->json([
              'status' => true,
              'image_id' => $tempImage->id,
              'ImagePath'=> asset('/temp/thumb/'.$newName),
              'message' => 'Image uploaded successfully'
          ]);
      }
  }
  
}
