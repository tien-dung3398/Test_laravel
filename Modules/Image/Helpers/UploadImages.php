<?php
namespace  Modules\Image\Helpers;

use Illuminate\Support\Facades\File;
use Modules\Image\Entities\Image;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class UploadImages
 * @package Modules\Image\Helper
 */
class UploadImages
{
    /**
     * @param $file
     * @param $folder
     * @param string $disk
     * @param string $file_name
     * @return array
     */
    public static function uploadImages($file, $folder, $disk = 'public', $file_name = "")
    {
        $base_path = base_path() . DIRECTORY_SEPARATOR . $disk;
        $date_folder = date("Ym");
        // $imageName = $file_name ?: date("YmdHis") . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $nameDisplay = md5($file->getClientOriginalName());
        $imageName = $file_name ?: date("YmdHis") . '_' . $nameDisplay . '.' . $extension;
        // $nameDisplay = $file->getClientOriginalName();
        $dir_original = implode(DIRECTORY_SEPARATOR, [$base_path, $folder, $date_folder]);
        if (!File::exists($dir_original)) {
            File::makeDirectory($dir_original, 0777, true);
        }
        $file->move($dir_original, $imageName);
        $path_original = $dir_original . DIRECTORY_SEPARATOR . $imageName;
        return [
            'name' => $nameDisplay,
            'url' => str_replace($base_path, '', $path_original),
            'path_thumbnail' => '',
        ];
    }
}

?>
