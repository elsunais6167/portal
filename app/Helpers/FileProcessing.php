<?php

 namespace App\Helpers;
 use Image;

 class FileProcessing
 {
    public function upload_file($request, string $file, $folder = 'passports')
    {
        $filename = str()->random(25);
        $extension = $request->file($file)->getClientOriginalExtension();
        $fileNameToStore = $filename  .'_'.time().'.'.$extension;
        $path = public_path().'/uploads/'.$folder;
        $path = $request->file($file)->move($path, $fileNameToStore);
        return  $fileNameToStore;
    }

 }
