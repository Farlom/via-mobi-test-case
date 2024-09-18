<?php

namespace App\Http\Services;

use App\Http\Requests\FilterRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function getProducts(FilterRequest $request)
    {
        $query = Product::query();

        if ($request->has('price')) {
            $query->whereBetween('price', $request->price);
        }

        if ($request->has('category')) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->has('sort')) {
            if ($request->sort == 'price_desc') {
                $query->orderByDesc('price');
            }
        }
        return $query->paginate(1)->withQueryString();
    }
}
