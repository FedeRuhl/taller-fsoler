<?php

namespace App\Services;

use App\Models\DepotProduct;
use DB;

class GenericService extends BaseService
{
    public function __construct($user_id)
    {
        parent::__construct($user_id);
        $this->errorDefinitions[] = new Error("GNR0001", "Unespected error", "Unespected", 500);
        $this->errorDefinitions[] = new Error("GNR0002", "Generic not found", "Not Found", 404);      
    }

    public function getTotalQuantityByGeneric($generic)
    {
        $availableStock = DB::table('products')
            ->join('depot_product', 'products.id', '=', 'depot_product.product_id')
            ->selectRaw('sum(stock) as stock')
            ->where('generic_id', $generic['id'])
            ->value('stock');

        $totalQuantity = ($availableStock >= $generic['total_quantity'])
            ? $generic['total_quantity']
            : $availableStock;

        return $totalQuantity ?? 0;
    }

    public function getTotalQuantities($generics)
    {
        return collect($generics)->mapWithKeys(function ($generic) {
            return [
                $generic['id'] => [
                    'generics_total_quantity' => $this->getTotalQuantityByGeneric($generic)
                ]
            ];
        });
    }

    public function updateStocks($generics)
    {
        foreach($generics as $generic)
        {
            $products = $generic->products()
                ->join('depot_product', 'depot_product.product_id', '=', 'products.id')
                ->select('products.id', 'depot_id', 'stock', 'expiration_date')
                ->where('stock', '>', 0)
                ->orderBy('expiration_date')
                ->get();

            $quantity = 0;
            $total = 0;

            foreach($products as $product)
            {
                if ($product->stock >= $generic->pivot->generics_total_quantity)
                {
                    $quantity = $generic->pivot->generics_total_quantity;
                }
                else 
                {
                    $quantity = $product->stock;
                }

                $total += $quantity;

                if ($genericRequestId = $generic->pivot->id)
                {
                    $product->genericRequests()->attach([
                        $genericRequestId => [
                            'products_quantity' => $quantity,
                            'depot_id' => $product->depot_id
                        ]
                    ]);
                }

                DepotProduct::where('depot_id', $product->depot_id)
                    ->where('product_id', $product->id)
                    ->update([
                        'stock' => $product->stock - $quantity
                    ]);

                if ($total == $generic->pivot->generics_total_quantity)
                {
                    break;
                }
            }
        }
    }
}