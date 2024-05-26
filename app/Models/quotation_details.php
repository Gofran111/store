<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class quotation_details extends Model
{
    use HasFactory;
    

    public function order(){
        return $this->belongsTo(quotation::class,'id');
    }
    public function qutation_details($id){
        return quotation_details::where('quot_id', $id)->get();
    }

}
