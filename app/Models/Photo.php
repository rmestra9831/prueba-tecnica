<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Livewire\WithFileUploads;

class Photo extends Model
{
    use HasFactory;
    use WithFileUploads;
    use SoftDeletes;

    Protected $fillable = ['user_id','url','state'];

    // relación de imagenes
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'timestamp',
    ];
}
