<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryCreateRequest;
use App\Http\Requests\Api\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke(Request $request)
    {}
    public function tambah(CategoryCreateRequest $request)
    {
        $model = $request->validated();
        $category = Category::create($model);

        return response()->json([
            'status' => true,
            'model' => $category->toArray()
        ]);
    }

    public function ubah(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        $model = $request->validated();

        try {
            $category = Category::findOrFail($id);
            $category->name = $model['name'] ?? $category->name;
            $category->update();

            return response()->json([
                'status' => true,
                'model' => $category->toArray()
            ]);
        } catch (Exception) {
            return response()->json([
                'success' => false,
                'failed' => [
                    'message' => 'Category not found'
                ]
            ], 400);
        }
    }

    public function hapus(int $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => true
            ]);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'pesan_error' => [
                    'message' => 'Category tidak ada'
                ]
            ], 400);
        }
    }

    public function ambil(int $id): JsonResponse
    {
        $category = Category::find($id);
        return response()->json([
            'status' => true,
            'model' => $category->toArray() ?? null
        ]);
    }

    public function ambilSemua(Request $request): JsonResponse
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'model' => $categories->toArray()
        ]);
    }
}
