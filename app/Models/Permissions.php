<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Permissions extends Model {
    use HasFactory;
    protected $table    = 'permissions';
    protected $fillable = ['name', 'slug'];
    protected $hidden   = ['pivot', 'slug', 'created_at', 'updated_at'];
    public function users() {
        return $this->belongsToMany(User::class, 'users_permissions', 'permission_id', 'user_id');
    }
}