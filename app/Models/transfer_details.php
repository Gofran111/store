<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class transfer_details extends Model
{
    use HasFactory;
    

    public function order(){
        return $this->belongsTo(transfer_orders::class,'id');
    }

    public function t_details($id){
        return transfer_details::where('tran_id', $id)->get();
    }
}
