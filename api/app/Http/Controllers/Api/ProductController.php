<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductCreateRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    public function __invoke(Request $request)
    {}
    private function simpan_gambar(UploadedFile $file): string
    {
        $path = 'uploads/images/products';
        $pathPenuh = public_path($path);
        $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($pathPenuh, $namaFile);

        return "{$path}/{$namaFile}";
    }

    private function hapus_gambar(Product $product): bool
    {
        $path = public_path($product->image);
        if (!file_exists($path)) {
            return false;
        }
        return unlink($path);
    }

    public function tambah(ProductCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['modified_by'] = Auth::user()->email;

        $file = $request->file('image');
        $path = $this->simpan_gambar($file);

        $data['image'] = $path;

        $product = Product::create($data);

        return response()->json([
            'status' => true,
            'model' => $product->toArray()
        ], 200);
    }

    public function ubah(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $data['modified_by'] = Auth::user()->email;
        $file = $request->file('image');

        try {
            $product = Product::findOrFail($id);

            $this->hapus_gambar($product);
            $data['image'] = $this->simpan_gambar($file);

            $product->update($data);

            return response()->json([
                'status' => true,
                'model' => $product->toArray()
            ]);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'pesan_error' => [
                    'message' => 'Product tidak ditemukan'
                ]
            ], 400);
        }
    }

    public function ambilSemua (Request $request): JsonResponse
    {
        $products = Product::all();

        return response()->json([
            'status' => true,
            'model' => $products
        ]);
    }

    public function ambil(int $id): JsonResponse
    {
        $product = Product::find($id);

        return response()->json([
            'status' => true,
            'model' => $product->toArray()
        ]);
    }

    public function hapus(int $id): JsonResponse
    {
        try {
            $category = Product::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => true
            ]);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'pesan_error' => [
                    'message' => 'Product not found'
                ]
            ], 400);
        }
    }
}
