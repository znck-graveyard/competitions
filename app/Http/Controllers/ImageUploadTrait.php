<?php namespace App\Http\Controllers;

use File;
use finfo;
use Illuminate\Http\Exception\HttpResponseException;
use Rhumsaa\Uuid\Uuid;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
trait ImageUploadTrait
{

    /**
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Uuid::uuid4()->toString() . '.' . $extension;
        Storage::disk()->put($filename, File::get($file));

        return $filename;
    }

    /**
     * @param $url
     *
     * @return string
     */
    protected function downloadFile($url)
    {
        $file = file_get_contents($url);
        $detector = new finfo(FILEINFO_MIME_TYPE);
        $extension = $this->getExtensionFromMimeType($detector->buffer($file));
        if (null === $extension) {
            throw new HttpResponseException(redirect()->back()->withInput()->withErrors('Invalid file type. Only jpg/png/tiff are allowed.'));
        }
        $filename = Uuid::uuid4()->toString() . '.' . $extension;
        Storage::disk()->put($filename, $file);

        return $filename;
    }

    /**
     * @param $mime
     *
     * @return null|string
     */
    protected function getExtensionFromMimeType($mime)
    {
        switch ($mime) {
            case 'image/jpeg':
                return 'jpg';
            case 'image/png':
                return 'png';
            case 'image/tiff':
                return 'tiff';
            default:
                return null;
        }
    }
}