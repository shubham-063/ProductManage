<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
	protected $primaryKey = 'id';
    
    protected $fillable = ['id','name', 'created_at', 'updated_at'];
    
    protected $appends = ['category'];

    public function getCategoryAttribute(){
        $product_id = $this->attributes['id'];
        $categories = CategoryProduct::join('categories', 'categories.id', '=', 'category_products.category_id')->select('categories.name')->where('category_products.product_id', $product_id)->groupBy('category_products.id')->get();
        $stringCategory = "";
        foreach($categories as $value){
            $stringCategory .= $value->name.", ";
        }
        $category = rtrim($stringCategory, ', ');
        return $this->attributes['category'] = $category;
    }
}
