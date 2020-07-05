<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'product_id'
                            ,'quantity'
                            ,'session_id'
                        ];
	public function product(){
		return $this->hasOne("App\Product","id","product_id");
	}                        

}
