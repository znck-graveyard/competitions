<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Image;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
trait ImageResponseTrait
{
    /**
     * @param $width
     * @param $height
     * @param $filename
     * @param $modified
     *
     * @return mixed
     */
    protected function sendImageResponse($width, $height, $filename, $modified)
    {
        if (!is_numeric($width)) {
            $width = null;
        }
        if ($height === null) {
            $height = $width;
        }

        $this->sendImage(response(''), md5($filename), $modified);

        $image = Image::make($filename);

        if ($width !== null) {
            $image->fit($width, $height);
        }

        return $this->sendImage($image->response(), md5($filename), $modified);
    }

    /**
     *
     * Send image function with headers
     *
     * @param \Illuminate\Http\Response $response
     * @param string                    $etag
     * @param string                    $modified
     * @param string                    $browserCache
     *
     * @return bool
     */
    protected function sendImage(Response $response, $etag, $modified = '', $browserCache = '')
    {

        if ($modified == '') {
            $modified = time();
        }

        if ($browserCache == '') {
            $browserCache = 86400000;
        }

        //header('Expires: '.gmdate('D, d M Y H:i:s', time()+$browserCache).' GMT');
        $response->setExpires(Carbon::createFromTimestamp(time() + $browserCache));

        //header('Last-Modified: ' . $lastModified);
        $response->setLastModified(Carbon::createFromTimestamp($modified));

        //header('ETag: ' . $eTag);
        $response->setEtag($etag);

        $notModified = false;

        $lastModified = $response->getLastModified();

        $modifiedSince = \Request::header('If-Modified-Since');

        if (!is_null($modifiedSince)) {


            if ($etags = \Request::header('etag')) {
                $notModified = in_array($response->getEtag(), $etags) || in_array('*', $etags);
            }

            if ($modifiedSince && $lastModified) {
                $notModified = strtotime($modifiedSince) >= $lastModified->getTimestamp() && (!$etags || $notModified);
            }

            if ($notModified) {
                $response->setNotModified();
                abort(304);
            }
        }

        return $response;
    }
}