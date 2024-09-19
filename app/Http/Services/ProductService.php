<?php

namespace App\Http\Services;

use App\Http\Requests\FilterRequest;
use App\Models\Product;

class ProductService
{
    /**
     * @param FilterRequest $request
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProducts(FilterRequest $request, int $perPage = 5): \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
        return $query->paginate($perPage)->withQueryString();
    }
}
