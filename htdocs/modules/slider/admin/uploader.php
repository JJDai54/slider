<?php
//$f['folder']  = SLIDER_UPLOAD_IMAGE_PATH . '/slides/'; 
$f['folder']  = XOOPS_ROOT_PATH . "/themes/{$theme}/css/images";
$f['maxwidth']  = (int)$helper->getConfig('maxwidth_image'); 
$f['maxheight']  = (int)$helper->getConfig('maxheight_image'); 
///////////////////////////////////////
if (!is_dir($f['folder'])) mkdir($f['folder'], 0774);
include_once XOOPS_ROOT_PATH . '/class/uploader.php';
    $uploaderErrors = '';
    $uploader = new \XoopsMediaUploader($f['folder'] , 
                                        $helper->getConfig('mimetypes_image'), 
                                        $helper->getConfig('maxsize_image'), null, null);
    
    foreach($_POST['xoops_upload_file'] AS $index => $ufName){ //$upload_file_name
        $uf = $_FILES[$ufName];
//sld_echoArray($uf, 'upload', 'green');
        
        

      //if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
      //-------------------------------------------------------
      if ($uploader->fetchMedia($_POST['xoops_upload_file'][$index])) {

          $h= strlen($uf['name']) - strrpos($uf['name'], '.');   
          $imgName = substr($uf['name'],0,-$h);
          $imgName = TexteSansAccent($imgName, "_");
          $uploader->setPrefix($imgName . "-");
          //$uploader->fetchMedia($_POST['xoops_upload_file'][$index]);
          
          
          if (!$uploader->upload()) {
              $uploaderErrors .= "\n" . $uploader->getErrors();
          } else {
              $savedFilename = $uploader->getSavedFileName();
              if ($f['maxwidth'] > 0 && $f['maxheight'] > 0) {
                  // Resize image
                  $imgHandler                = new Slider\Common\Resizer();
                  //$endFile = "{$theme}-{$savedFilename}" ;
                  
                  $imgHandler->sourceFile    = $f['folder']  . $savedFilename;
                  $imgHandler->endFile       = $f['folder']  . $savedFilename;
                  $imgHandler->imageMimetype = $uf['type'];
                  $imgHandler->maxWidth      = $f['maxwidth'];
                  $imgHandler->maxHeight     = $f['maxheight'];
                  $result                    = $imgHandler->resizeImage();
                  
              }
                  $t = explode('|', $_POST['xoops_upload_file'][$index]);
                  $attributs[$t[0]][$t[1]] = 'images/' . $savedFilename;

          }
      } else {
          if ($f['name'] != '') {
              $uploaderErrors = $uploader->getErrors();
          }
      }
    
    
    
    }

?>