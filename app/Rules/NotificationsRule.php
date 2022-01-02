<?php
namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
class NotificationsRule implements Rule {
    public function passes($attribute, $value) {
        return auth()->user()->can("nc_$value");
    }
    public function message() {
        return trans('validation.notifications');
    }
}