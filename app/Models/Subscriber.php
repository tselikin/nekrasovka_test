<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];
    protected $fillable = ['email'];
    public $timestamps = false;

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
}
