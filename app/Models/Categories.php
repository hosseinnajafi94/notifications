<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class Categories extends Model {
    use HasFactory,
        SoftDeletes;
    protected $table    = 'categories';
    protected $fillable = ['title'];
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];
    public function notifications() {
        return $this->hasMany(Notifications::class, 'category_id', 'id');
    }
    public function validate(Request $request) {
        $options = ['title' => 'required|string|max:255|unique:categories'];
        if ($this->id) {
            //$options['title'] = ['required', 'string', 'max:255', Rule::unique('categories')->ignore($this->id)];
            $options['title'] = 'required|string|max:255|unique:categories,id,' . $this->id;
        }
        return $request->validate($options);
    }
}