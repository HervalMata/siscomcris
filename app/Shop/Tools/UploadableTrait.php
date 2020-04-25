<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 18:02
 */

namespace App\Shop\Addresses\Repositories;


use Illuminate\Support\Str;

trait UploadableTrait
{
    /**
     * @param $file
     * @param null $folder
     * @param string $disk
     * @return false|string
     */
    public function uploadOne($file, $folder = null, $disk = 'uploads')
    {
        return request()->file('cover')->storeAs(
            $folder, Str::random(25) . "." . $file->getClientOriginalExtension(), $disk
        );
    }
}
