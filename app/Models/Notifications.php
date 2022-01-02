<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Rules\NotificationsRule;
use App\Components\Functions;
use Illuminate\Http\Request;
class Notifications extends Model {
    use HasFactory,
        SoftDeletes;
    protected $table    = 'notifications';
    protected $fillable = ['category_id', 'title', 'description', 'file', 'exp_time'];
    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];
    public function category() {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
    public function validate(Request $request) {
        $options   = [
            'category_id' => ['required', 'integer', 'exists:App\Models\Categories,id,deleted_at,NULL', new NotificationsRule()],
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'file'        => 'nullable|file|max:10240',
            'exp_time'    => 'required|date_format:Y-m-d H:i:s',
        ];
        $validated = $request->validate($options);

        $validated['file'] = Functions::upload($validated, 'file', 'uploads', $this->file);
        return $validated;
    }
}