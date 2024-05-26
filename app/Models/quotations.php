<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class quotations extends Model
{
    use HasFactory;

    public function details(){
        return $this->hasMany(quotation_details::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function quotations_list($id){
        return quotations::where('id',$id)->first();
    }
}
