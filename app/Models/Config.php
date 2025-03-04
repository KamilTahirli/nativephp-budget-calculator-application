<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['seeded'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
