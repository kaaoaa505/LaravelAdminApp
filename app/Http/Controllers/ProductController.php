<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('view', 'products');

        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        Gate::authorize('view', 'products');

        return new ProductResource($product);
    }

    public function store(ProductCreateRequest $request)
    {
        Gate::authorize('edit', 'products');

        $data = $request->all();

        $image_path = $request->file('image')->store('uploads', 'public');

        $data['image'] = $image_path;

        $product = Product::create($data);

        return response($product, Response::HTTP_CREATED);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        Gate::authorize('edit', 'products');

        $data = $request->all();

        if (request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('uploads', 'public');
        }else{
            unset($data['image']);
        }

        $product->update($data);

        return response($product, Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        Gate::authorize('edit', 'products');

        Product::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
