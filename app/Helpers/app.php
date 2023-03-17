<?php

use App\Models\User;

function upload_file($file, $folder = 'passports')
{
    $filename = str()->random(25);
    $extension = $file->getClientOriginalExtension();
    $fileNameToStore = $filename  .'_'.time().'.'.$extension;
    $path = public_path().'/uploads/'.$folder;
    $path = $file->move($path, $fileNameToStore);
    return  $fileNameToStore;
}

function display_image($img = '', $img_class = 'img-40', $folder = "passports")
{
    if( $img ){
        echo "<img class='img-thumbnail $img_class' src='/uploads/$folder/$img'>";
    }else{
        return "No Image";
    }
}

function current_user()
{
    return auth()->user();
}

function find_user($user_id)
{
    return User::whereId($user_id)->first();
}