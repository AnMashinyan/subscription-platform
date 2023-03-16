<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'website_id'
    ];


    public function website()
    {
        return $this->belongsToMany(Website::class);
    }
}
