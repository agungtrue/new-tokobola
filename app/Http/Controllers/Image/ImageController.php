<?php

namespace App\Http\Controllers\Image;

use Cache;
use Closure;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Support\Response\Json;
use App\Support\Generate\Hash as GenerateKey;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $Image = $request->Payload->all()['Image'];
        $NameImage = $Image->getClientOriginalName();
        $ExtensionImage = $Image->getClientOriginalExtension();
        $SizeImage = $Image->getSize();
        $MimeType = $Image->getMimeType();
        $KeyName = GenerateKey::Random();
        $Name = $KeyName . '-original.' . $ExtensionImage;
        $NameSmall = $KeyName . '-small.' . $ExtensionImage;
        $Image->move(Storage::disk('temporary')->getAdapter()->getPathPrefix(), $Name);

        $img = Image::make(Storage::disk('temporary')->get($Name));
        $img->fit(300, 300, function ($constraint) {
            $constraint->upsize();
        });
        $img->save(Storage::disk('temporary')->getAdapter()->getPathPrefix() . $NameSmall);

        Json::set('data', [
            'key' => $KeyName,
            'extension' => $ExtensionImage,
            'original' => $Name
        ]);
        return response()->json(Json::get(), 201);
    }
}
