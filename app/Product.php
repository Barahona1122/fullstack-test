<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'name'
                            ,'slug'
                            ,'description'
                            ,'price'
                            ,'status'
                            ,'urser_id'
                        ];
	public function user(){
		return $this->hasOne("App\User","id","user_id");
	}                        

}
