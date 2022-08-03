<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class Product extends Model
{
    use HasFactory;
    private $base_path="http://127.0.0.1:8000/public/Image/";

    protected $fillable = ["name", "picture"];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }
    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getPictureAttribute($value){
        return $this->base_path.$value;
    }

}
