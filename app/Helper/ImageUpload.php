<?php

namespace App\Helper;

class ImageUpload
{

    public static function uploadImage($file)
    {
        // return "function is working";
        $image = $file; //$_FILES["coverimageurl"] accept argument as argument.

        if (gettype($image["name"]) == "array" && count($image["name"]) > 0) {


            $allImage = array();
            foreach ($image["name"] as $key => $value) {

                if ($image["name"][$key] != "" && $image["name"][$key] != null) {

                    $target_dir = "public/img/product/details/fullview/";
                    $target_file = $target_dir . basename($image["name"][$key]);

                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // change the current time name 
                    $Uniquefilename = uniqid() . "." . $imageFileType;
                    // $formatted_date = date("Y-m-d H:i:s");
                    $number_date = time(); //timestap unformated
                    $newNameOfFile = $number_date . "murtijeevan" . $Uniquefilename;
                    $target_file = $target_dir .  $newNameOfFile;



                    $check = getimagesize($image["tmp_name"][$key]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        // return "File is not an image.";
                        return  [
                            "status" => "failed",
                            "message" => "File is not an image."
                        ];
                        $uploadOk = 0;
                    }


                    // Check if file already exists
                    if (file_exists($target_file)) {
                        // return "Sorry, file already exists.";
                        return [
                            "status" => "failed",
                            "message" => "Sorry, file already exists."
                        ];
                        $uploadOk = 0;
                    }

                    // Check file size
                    if ($image["size"][$key] > 50000000) {
                        //return "Sorry, your file is too large.";
                        return [
                            "status" => "failed",
                            "message" => "Sorry, your file is too large."
                        ];
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if (
                        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    ) {
                        //return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        return [
                            "status" => "failed",
                            "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."
                        ];
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        //return "Sorry, your file was not uploaded.";
                        return [
                            "status" => "failed",
                            "message" => "Sorry, your file was not uploaded."
                        ];
                        // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($image["tmp_name"][$key], $target_file)) {
                            // echo "The file " . htmlspecialchars(basename($image["name"])) . " has been uploaded.";
                            array_push($allImage, $newNameOfFile);
                        } else {
                            return  [
                                "status" => "failed",
                                "message" => "Sorry, there was an error uploading your file"
                            ];
                            // return "Sorry, there was an error uploading your file.";
                        }
                    }
                } else {
                    //return "File Is Not Found !!";
                    return  [
                        "status" => "failed",
                        "message" => "File Is Not Found !!"
                    ];
                }
            }

            return [
                "status" => "success",
                "message" => "Successfully uploaded",
                "allImage" => $allImage
            ];
        } else {
            if ($image["name"] != "" && $image["name"] != null) {

                $target_dir = "public/img/product/";
                $target_file = $target_dir . basename($image["name"]);

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // change the current time name 
                $Uniquefilename = uniqid() . "." . $imageFileType;
                // $formatted_date = date("Y-m-d H:i:s");
                $number_date = time(); //timestap unformated
                $newNameOfFile = $number_date . "murtijeevan" . $Uniquefilename;
                $target_file = $target_dir .  $newNameOfFile;


                $check = getimagesize($image["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    // return "File is not an image.";
                    return  [
                        "status" => "failed",
                        "message" => "File is not an image"
                    ];
                    $uploadOk = 0;
                }


                // Check if file already exists
                if (file_exists($target_file)) {
                    //return "Sorry, file already exists.";
                    return  [
                        "status" => "failed",
                        "message" => "Sorry, file already exists."
                    ];
                    $uploadOk = 0;
                }

                // Check file size
                if ($image["size"] > 50000000) {
                    // return "Sorry, your file is too large.";
                    return  [
                        "status" => "failed",
                        "message" => "Sorry, your file is too large."
                    ];
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"
                ) {
                    // return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    return  [
                        "status" => "failed",
                        "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."
                    ];
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    // return "Sorry, your file was not uploaded.";
                    return  [
                        "status" => "failed",
                        "message" => "Sorry, your file was not uploaded."
                    ];
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                        // echo "The file " . htmlspecialchars(basename($image["name"])) . " has been uploaded.";
                        // return $newNameOfFile;
                        return  [
                            "status" => "success",
                            "message" => "Successfully Uploaded",
                            "newNameOfFile"=>$newNameOfFile
                        ];
                    } else {
                        // return "Sorry, there was an error uploading your file.";
                        return  [
                            "status" => "failed",
                            "message" => "File is not an image"
                        ];
                    }
                }
            } else {
                // return "File Is Not Found !!";
                return  [
                    "status" => "failed",
                    "message" => "File is not an image"
                ];
            }
        }
    }
}
