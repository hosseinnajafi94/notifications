<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
class User extends Authenticatable implements JWTSubject {
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes;
    protected $table    = 'users';
    protected $fillable = ['fname', 'lname', 'username', 'password', 'email'];
    protected $hidden   = ['password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts    = ['email_verified_at' => 'datetime'];
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    public function getJWTCustomClaims() {
        return [];
    }
    public function permissions() {
        return $this->belongsToMany(Permissions::class, 'users_permissions', 'user_id', 'permission_id');
    }
    public function hasPermission($permission) {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }
    public function validate(Request $request) {
        $options = [
            'fname'         => 'required|string|max:255',
            'lname'         => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users',
            'password'      => 'required|string|max:255',
            'email'         => 'nullable|string|max:255',
            'permissions'   => "nullable|array",
            'permissions.*' => "required|string|distinct|exists:App\Models\Permissions,id",
        ];
        if ($this->id) {
            $options['username'] = 'required|string|max:255|unique:users,id,' . $this->id;
            $options['password'] = 'nullable|string|max:255';
        }
        return $request->validate($options);
    }
}