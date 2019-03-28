<?php

// include composer autoload
// include_path='C:\xampp\php\PEAR'
require 'vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

    $errors = array();
    if(isset($_FILES["image"])){
        $fileSize = $_FILES["image"]["size"];
        $fileTmp = $_FILES["image"]["tmp_name"];
        $fileType = $_FILES["image"]["type"];

        // var_dump($fileSize);
        // var_dump($fileTmp);
        // var_dump($fileType);

        //If the file is over 5mb
        if($fileSize > 5000000){
            array_push($errors, "The file is to large, must be under 5MB");
        }

        //Check to see if the image is the right type
        $validExtensions = array("jpeg", "jpg", "png");
        $fileNameArray = explode(".", $_FILES["image"]["name"]);

        $fileExt = strtolower(end($fileNameArray));

        if(in_array($fileExt, $validExtensions) === false){
            array_push($errors, "File type not allowed, can only be a jpg or png");
        }

        if(empty($errors)){

            $destination = "images/uploads";
            if(! is_dir($destination) ){
                mkdir("images/uploads/", 0777, true);
            }

            $newFileName = uniqid() .".".  $fileExt;
            // move_uploaded_file($fileTmp, $destination."/".$newFileName);

            $manager = new ImageManager();

            $mainImage = $manager->make($fileTmp);
            $mainImage->save($destination."/".$newFileName, 100);

            $thumbnailImage = $manager->make($fileTmp);
            $thumbDestination = "images/uploads/thumbnails";
            if(! is_dir($thumbDestination)){
                mkdir("images/uploads/thumbnails/", 0777, true);
            }
            $thumbnailImage->resize(300, null, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $thumbnailImage->save($thumbDestination."/".$newFileName, 100);
        }
    }
    
    $page = "imageUpload";
    $desc = "This is the description of the Image Upload Page";
    require("templates/header.php");
 ?>

<main role="main" class="inner cover">
    <h1 class="cover-heading">Image Upload Page</h1>
    <p class="lead">Upload an image to our server</p>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach($errors as $singleError): ?>
                    <li><?= $singleError; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="imageUpload.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">Upload an Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-outline-light btn-block">Submit</button>
    </form>


</main>

<?php require("templates/footer.php"); ?>
