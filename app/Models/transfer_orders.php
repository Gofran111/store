<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class transfer_orders extends Model
{
    use HasFactory;

    public function details(){
        return $this->hasMany(transfer_details::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function transfer_list(){
        return transfer_orders::all();
    }

     //transfer show
     public function transfer($id){
        return transfer_orders::where('id', $id)->first();
    }
}
