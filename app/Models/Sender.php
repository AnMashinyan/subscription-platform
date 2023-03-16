<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'is_send',
        'email',
        "website_id"
    ];

    public function post()
    {
        return $this->belongsToMany(Post::class);
    }


}
