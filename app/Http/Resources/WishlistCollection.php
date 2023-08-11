<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Review;
use App\Models\Attribute;
class WishlistCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'product' => [
                        'product_id' => $data->product->id,
                        'name' => $data->product->name,
						'sku' => $data->product->sku,
                        'thumbnail_image' => api_asset($data->product->thumbnail_img),
                        'base_price' => (double) homeBasePrice($data->product->id),
                        'base_discounted_price' => (double) homeDiscountedBasePrice($data->product->id),
                        'unit' => $data->product->unit,
                        'rating' => (double) $data->product->rating,
                        'links' => [
                            'details' => route('products.show', $data->product->id),
                            'reviews' => route('api.reviews.index', $data->product->id),
                            'related' => route('products.related', $data->product->id),
                            'top_from_seller' => route('products.topFromSeller', $data->product->id)
                        ],
                    'category' => [
                        'name' =>  $data->product->category->name,
                        'name2' =>  $data->product->category->name1,
                        'banner' => api_asset( $data->product->category->banner),
                        'icon' =>  $data->product->category->icon,
                        'category_links' => [
                            'products' => route('api.products.category',  $data->product->category_id),
                            'sub_categories' => route('subCategories.index',  $data->product->category_id)
                        ]
                    ],
					'brand' => [
                        'name' => $data->product->brand != null ? $data->product->brand->name : null,
                        'logo' => $data->product->brand != null ? api_asset($data->product->brand->logo) : null,
                        'brand_links' => [
                            'products' => $data->product->brand != null ? route('api.products.brand', $data->product->brand_id) : null
                        ]
                    ],
				//	'photos' => $this->convertPhotos(explode(',', $data->product->photos)),
                   
                    'tags' => explode(',', $data->product->tags),
                    'price_lower' => (double) explode('-', homeDiscountedPrice($data->product->id))[0],
                    'price_higher' => (double) explode('-', homeDiscountedPrice($data->product->id))[1],
               //   'choice_options' => $this->convertToChoiceOptions(json_decode($data->product->choice_options)),
                    'colors' => json_decode($data->product->colors),
                    'todays_deal' => (integer) $data->product->todays_deal,
                    'featured' => (integer) $data->product->featured,
                    'current_stock' => (integer) $data->product->current_stock,
                    'unit' => $data->product->unit1,
                    'discount' => (double) $data->product->discount,
                    'discount_type' => $data->product->discount_type,
                    'tax' => (double) $data->product->tax,
                    'tax_type' => $data->product->tax_type,
                    'shipping_type' => $data->product->shipping_type,
                    'shipping_cost' => (double) $data->product->shipping_cost,
                    'number_of_sales' => (integer) $data->product->num_of_sale,
                    'rating' => (double) $data->product->rating,
                    'rating_count' => (integer) Review::where(['product_id' => $data->product->id])->count(),
                    'description' => strip_tags($data->product->description1),
                    ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
