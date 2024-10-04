<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function getAll()
    {
        try {
            $products = Product::all();
            if ($products->isEmpty()) {
                return response()->json(['message' => 'No hay productos registrados'], 200);
            }
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener datos.'], 500);
        }
    }

    public function getById($id)
    {
        try {
            $product = Product::find($id);
            if ($product == null) {
                return response()->json(['message' => 'Producto con ' . $id . ' no encontrado.'], 404);
            }
            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al obtener el producto '], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto con ' . $id . 'no encontrado.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'description' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|numeric|gte:0.00'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 404);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
        return response()->json(['message' => 'Producto actualizado correctamente'], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'description' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|numeric|gte:0.00'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 404);
        }

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Producto con id ' . $id . ' no encontrado'], 404);
            }
            $product->delete();
            return response()->json(['message' => 'Producto con id ' . $id . ' fué eliminado.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al eliminar el producto'], 500);
        }
    }
}
