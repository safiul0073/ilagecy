<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class GlobalProductIdService
{
    public static $filename = 'id.json';

    private static function getFile()
    {
        return Storage::disk('local')->get(self::$filename);
    }

    public static function put()
    {
        $product_id = json_decode(self::getFile(), true);

        if (request()->input('pid') === "0") {
            $product_id[auth()->user()->id] = 0;
        } elseif (request()->input('pid') !== null) {
            $product_id[auth()->user()->id] = intval(request()->input('pid'));
        }

        Storage::put(self::$filename, json_encode($product_id));
    }

    public static function get()
    {
        $id = json_decode(Storage::disk('local')->get(self::$filename), true);
        return $id[auth()->user()->id];
    }
}
