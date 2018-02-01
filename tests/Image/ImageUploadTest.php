<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadTest extends TestCase
{
    /** @test **/
    public function uploadImage()
    {
        $folder = __DIR__.'/files';
        $tmp = __DIR__.'/tmp';
        $name = 'jpgimage' . '.jpg';
        $path = $folder . '/'.$name;
        $temPath = $tmp . '/' . $name;
        copy($path, $temPath);
        $file = new UploadedFile($temPath, $name, filesize($temPath), 'image/jpg', null, true);
        $this->call('POST', '/image', [], [], [
            'image' => $file
        ], ['Accept' => 'application/json']);
        $content = json_decode($this->response->getContent());
        if (isset($content->data->key) && isset($content->data->extension)) {
            $original = $content->data->key . '-original.'. $content->data->extension;
            $small = $content->data->key . '-small.'. $content->data->extension;
        } else {
            $original = '';
            $small = '';
        }
        Storage::disk('temporary')->assertExists($original);
        Storage::disk('temporary')->assertExists($small);
    }
}
