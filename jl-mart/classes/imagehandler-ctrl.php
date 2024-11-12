<?php

function imageHandler($image, $header)
{
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageType = $image['type'];

    $imageExt = explode('.', $imageName);
    $imageActualExt = strtolower(end($imageExt));

    $allowed = array('jpg', 'jpeg', 'png', 'webp', 'tmp');

    if (in_array($imageActualExt, $allowed)) {
        if ($imageError === 0) {
            if ($imageSize < 50000000) {
                $imageNewName = uniqid(time(), true) . "." . $imageActualExt;

                $imageDestination = '../views/images/' . $imageNewName;

                move_uploaded_file($imageTmpName, $imageDestination);
            } else {
                header("location: {$header}?message=Successfully Uploaded");
                exit();
            }
        } else {
            header("location: {$header}?message=Uploading Error");
            exit();
        }
    } else {
        header("location: {$header}?message={$imageActualExt} Files cannot be uploaded");
    }

    return array("newName" => $imageNewName, "destination" => $imageDestination);
}
