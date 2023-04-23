<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
      protected $fillable = [
        'title',
        'user_id',
        'tags',
        'logo',
        'location',
        'company',
        'email',
        'website',
        'description' ,
    ]; 

    public function scopeFilter($query, array $filters){
      //dd($filter['tag']);  
       if($filters['tag'] ?? false )   {
        $query ->where('tags', 'like', '%'.request('tag').'%'  );
      }  
      if($filters['search'] ?? false )   {
        $query ->where('title', 'like', '%'.request('search').'%'  )
        ->orWhere->where('description', 'like', '%'.request('search').'%'  )
        ->orWhere->where('tags', 'like', '%'.request('search').'%'  )
        ;
      }    
    }
     // Relationship to User
     public function user(){
      return $this->belongsTo(User::class, 'user_id');
     }
} ?>