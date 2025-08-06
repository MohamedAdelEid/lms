<?php

namespace App\Traits;

trait UploadImage
{

public function UploadImage($request, $imageFromRequest, $imageFolder)
{
        if ($request->hasFile($imageFromRequest) && $request->file($imageFromRequest)->isValid()) {
        $uploadedImage = $request->file($imageFromRequest);
        $imageExtension = $uploadedImage->getClientOriginalExtension();
            $formatedTime = date('Y-m-d_H-i-s');
            $imageName = $formatedTime.'.'.$imageExtension;
        $uploadedImage->move(public_path('images/' . $imageFolder), $imageName);
        return $imageName;
        }
        else
        {
        return 'default.jpg';
        }
}
}
