<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ExampleCRUD extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "example_CRUDS";
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "name",
        "age",
        "email",
        "last_updated_by"
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    protected static function booted() {
        static::updating(function (ExampleCRUD $exampleCRUD) {
            $exampleCRUD->last_updated_by = Auth::id();
        });
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by', 'id');
    }

}
