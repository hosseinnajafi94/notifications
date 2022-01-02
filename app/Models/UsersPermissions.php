<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UsersPermissions extends Model {
    use HasFactory;
    protected $table    = 'users_permissions';
    protected $fillable = ['user_id', 'permission_id'];
    protected $hidden   = ['created_at', 'updated_at'];
    public function users() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }
    public function permissions() {
        return $this->belongsTo(Permissions::class, 'permission_id', 'id');
    }
}