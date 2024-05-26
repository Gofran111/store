<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class 	store_movemnts_details extends Model
{
    use HasFactory;
    public function store_details($id){
        return store_movemnts_details::where('ord_id', $id)->get();
    }
    
}
