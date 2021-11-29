<?php
require_once(__DIR__."../../common/modules.php");

class Image{
    public static function compress_image($file, $imageName, $dest, $quality=90) {
          $explode = explode(".", $file);
          $filetype = $explode[1];

          if ($filetype == 'jpg') {
              $srcImg = imagecreatefromjpeg("$file");
          } else
          if ($filetype == 'jpeg') {
              $srcImg = imagecreatefromjpeg("$file");
          } else
          if ($filetype == 'png') {
              $srcImg = imagecreatefrompng("$file");
          } else
          if ($filetype == 'gif') {
              $srcImg = imagecreatefromgif("$file");
          }

          $origWidth = imagesx($srcImg);
          $origHeight = imagesy($srcImg);

          $thumbWidth=500;
          $thumbHeight=500;

          $ratio = $origWidth / $thumbWidth;
          $thumbHeight = $origHeight / $ratio;

          $thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
          imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
          imagejpeg($thumbImg, $dest.$imageName, $quality);

          return $imageName;
    }

    public static function uploader($zFILES, $id) {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
         //If directory doesnot exists create it.
        if(Services::ip_is_private($_SERVER['DOCUMENT_ROOT'])==false){
           $output_dir = $_SERVER['DOCUMENT_ROOT']."/public/upload/" . $id . "/"; // $_SERVER['DOCUMENT_ROOT']. "/public/upload/" . $id . "/"; ORINARY SERVER
        } 
        if(Services::ip_is_private($_SERVER['DOCUMENT_ROOT'])){
          $output_dir = $_SERVER['DOCUMENT_ROOT']. "/mpp/public/upload/" . $id . "/";
        }
        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
           $output_dir = $_SERVER['DOCUMENT_ROOT']. "/mpp/public/upload/" . $id . "/";
        }
        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        $path = "public/upload/" . $id . "/";

       if(isset($zFILES)){
              $img = $zFILES['name'];
              $source =  $zFILES['tmp_name'];
              $temp = explode(".", $zFILES["name"]);
              $newfilename = round(microtime(true) * rand(1,100)) . '.' . end($temp);
              $target =  $output_dir.$newfilename;              

           if (move_uploaded_file($source, $target)) {
            $name = self::compress_image($target, $newfilename, $output_dir);
           }
           return $path . $name;
        }
    }

    public static function uploadpic($zFILES, $id) {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
         //If directory doesnot exists create it.
       if(Services::ip_is_private($_SERVER['DOCUMENT_ROOT'])==false){
           $output_dir = $_SERVER['DOCUMENT_ROOT']."/public/upload/property/" . $id . "/";
        } 
        if(Services::ip_is_private($_SERVER['DOCUMENT_ROOT'])){
          $output_dir = $_SERVER['DOCUMENT_ROOT']. "/mpp/public/upload/property/" . $id . "/";
        }
        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
           $output_dir = $_SERVER['DOCUMENT_ROOT']. "/mpp/public/upload/property/" . $id . "/";
        }

        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        $path = "public/upload/property/" . $id . "/";

       if(isset($zFILES)){
              $img = $zFILES['name'];
              $source =  $zFILES['tmp_name'];
              $temp = explode(".", $zFILES["name"]);
              $newfilename = round(microtime(true) * rand(1,100)) . '.' . end($temp);
              $target =  $output_dir.$newfilename;

         if (move_uploaded_file($source, $target)) {
           $name = self::compress_image($target, $newfilename, $output_dir);
         }
         return $path . $name;
        }
    }

    public static function getTownMaps($map) {
            $files = array();

            switch ($map) {
                case 'bahria':
                    $files = array(
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_1-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_2-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_3-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_4-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_6-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_7-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_8-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_9-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_10-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_11-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_14-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_15-15a-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_16-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_17-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_18-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_19-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_20-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_21-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_22-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_23-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_24-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_25-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_26-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_27_A-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_27-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_28-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_29-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_30-01.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_31-01.jpg"
                            );
                    break;
                case 'dha':
                    $files = array(
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dha/DHA_Phase_1-7.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dha/DHA_Phase_2.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dha/DHA_Phase_8_8Ext.jpg"
                            );
                    break;
                case 'dhac':
                    $files = array(
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dhac/all_dhac_plan.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dhac/dhac1.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dhac/dhac2.jpg"
                            );
                    break;  
                default:
                    break;
            }

           natsort($files);
 
           return $files;
    }

    public static function getTownMapsWithName($map) {
            $files = array();

            switch ($map) {
                case 'bahria':
                    $files = array(
                                    "Precinct_1"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_1-01.jpg",
                                    "Precinct_2"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_2-01.jpg",
                                    "Precinct_3"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_3-01.jpg",
                                    "Precinct_4"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_4-01.jpg",
                                    "Precinct_6"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_6-01.jpg",
                                    "Precinct_7"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_7-01.jpg",
                                    "Precinct_8"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_8-01.jpg",
                                    "Precinct_9"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_9-01.jpg",
                                    "Precinct_10"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_10-01.jpg",
                                    "Precinct_11"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_11-01.jpg",
                                    "Precinct_14"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_14-01.jpg",
                                    "Precinct_15a"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_15-15a-01.jpg",
                                    "Precinct_16"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_16-01.jpg",
                                    "Precinct_17"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_17-01.jpg",
                                    "Precinct_18"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_18-01.jpg",
                                    "Precinct_19"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_19-01.jpg",
                                    "Precinct_20"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_20-01.jpg",
                                    "Precinct_21"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_21-01.jpg",
                                    "Precinct_22"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_22-01.jpg",
                                    "Precinct_23"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_23-01.jpg",
                                    "Precinct_24"=> "http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_24-01.jpg",
                                    "Precinct_25"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_25-01.jpg",
                                    "Precinct_26"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_26-01.jpg",
                                    "Precinct_27_A"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_27_A-01.jpg",
                                    "Precinct_27"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_27-01.jpg",
                                    "Precinct_28"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_28-01.jpg",
                                    "Precinct_29"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_29-01.jpg",
                                    "Precinct_30"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_30-01.jpg",
                                    "Precinct_31"=>"http://res.cloudinary.com/daf9havvb/image/upload/maps/bahria/Precinct_31-01.jpg"
                            );
                    break;
                case 'dha':
                    $files = array(
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dha/DHA_Phase_1-7.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dha/DHA_Phase_2.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dha/DHA_Phase_8_8Ext.jpg"
                            );
                    break;
                case 'dhac':
                    $files = array(
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dhac/all_dhac_plan.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dhac/dhac1.jpg",
                                    "http://res.cloudinary.com/daf9havvb/image/upload/maps/dhac/dhac2.jpg"
                            );
                    break;  
                default:
                    break;
            }

           natsort($files);
 
           return $files;
    }

    public static function __getTownMaps__($map) {
            $imgDir = "";
            switch ($map) {
                case 'bahria':
                    $imgDir = "maps/bahria_town/";
                    break;
                case 'dha':
                    $imgDir = "maps/dha/";
                    break;
                case 'dhac':
                    $imgDir = "maps/dha_city/";
                    break;  
                default:
                    break;
            }
               
           $dir = getcwd() . '/' . $imgDir;
           $files = array();
 
           if (is_dir($dir)){
             if ($dh = opendir($dir)){
               while (($file = readdir($dh)) !== false){
                 if ($file == '.' || $file == '..') {
                     continue;
                 }
                 $files[] = $file;
                     
               }
               closedir($dh);
             }
           }
 
           natsort($files);
 
           return $files;
    }
}
?>