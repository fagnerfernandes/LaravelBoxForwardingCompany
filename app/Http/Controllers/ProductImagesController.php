<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductImagesController extends Controller
{
    public function index($product_id)
    {
        $product = Product::findOrFail($product_id);
        $rows = ProductImage::where('product_id', $product_id)->paginate();
        return view('product_images.index', compact('rows', 'product'));
    }

    public function store(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Erro na validacao da imagem'], 422);
        }

        $product = Product::findOrFail($product_id);

        logger()->debug('dados da requisicao', [$request->all()]);

        if (!$request->file('image')->isValid()) {
            return response()->json(['success' => false, 'message' => 'Imagem inválida'], 422);
        }

        $filename = $product->code .'-'. date('YmdHis') .'.'. $request->file('image')->getClientOriginalExtension();

        if (!$request->file('image')->storeAs('products', $filename)) {
            return response()->json(['success' => false, 'message' => 'Houve um erro ao fazer upload da imagem'], 422);
        }

        if ($image = ProductImage::create(['product_id' => $product_id, 'image' => $filename])) {
            return response()->json(['success' => true, 'image' => $image]);
        }
        return response()->json(['success' => false, 'message' => 'Houve um erro ao gravar no banco de dados'], 422);
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        if ($image->delete()) {
            Storage::delete('products/'. $image->image);
            flash()->success('Imagem do produto removida com sucesso!');
        } else {
            flash()->error('Houve um erro ao remover a imagem do produto');
        }
        return redirect()->to(route('product_images.index', $image->product_id));
    }
}