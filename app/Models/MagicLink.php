<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagicLink extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'token', 'tenant_id', 'expires_at'];
}
