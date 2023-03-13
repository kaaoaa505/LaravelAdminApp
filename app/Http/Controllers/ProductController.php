<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductCreateRequest $request)
    {
        $data = $request->all();

        $image_path = $request->file('image')->store('uploads', 'public');

        $data['image'] = $image_path;

        $product = Product::create($data);

        return response($product, Response::HTTP_CREATED);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->all();

        if (request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('uploads', 'public');
        }else{
            unset($data['image']);
        }

        $product->update($data);

        return response($product, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
