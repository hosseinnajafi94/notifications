<?php
namespace App\Components;
class Functions {
    public static function upload($validated, $attribute, $path, $defaultValue = null) {

        if (!isset($validated[$attribute]) || !$validated[$attribute] instanceof \Illuminate\Http\UploadedFile) {
            return $defaultValue;
        }

        /* @var $file \Illuminate\Http\UploadedFile */
        $file = $validated[$attribute];
        $ext  = $file->getClientOriginalExtension();
        $name = uniqid(time(), true) . '.' . $ext;
        $file->move($path, $name);

        return $name;
    }
}