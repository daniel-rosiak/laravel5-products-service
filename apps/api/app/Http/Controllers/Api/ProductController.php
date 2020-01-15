<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductStoreRequest;
use App\Product;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ProductResource::collection($product->paginate())->hide(['url', 'abstract', 'description', 'created_at', 'updated_at']);
    }

    /**
     * Display a product.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Store a product to the database.
     *
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws InternalErrorException
     */
    public function store(ProductStoreRequest $request)
    {
        //@TODO this should be done in repository
        $product = new Product();
        $product->fill( $request->validated() );
        $product->save();

        if ( $product instanceof Product ) {
            return ProductResource::make($product);
        }
        throw new InternalErrorException('internal_error');
    }
}