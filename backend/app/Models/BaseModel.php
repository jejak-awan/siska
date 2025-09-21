<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Base Model untuk SISKA Backend System
 * 
 * @package App\Models
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
abstract class BaseModel extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     */
    protected $connection = 'backend';

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the table name for the model.
     */
    public function getTable()
    {
        return $this->table ?? str_replace('\\', '', Str::snake(class_basename($this)));
    }
}
