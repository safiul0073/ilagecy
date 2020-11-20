<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class GlobalProductIdService
{
    public static function get()
    {
        return intval(Storage::disk('local')->get('id.txt'));
    }
}
