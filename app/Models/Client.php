<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'company',
        'description',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
