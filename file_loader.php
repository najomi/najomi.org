<?php
include('base.php');
include('boot/bu_core.php');
function getExt($url){
    $ext = explode('.',$url);
    if(count($ext)>1)
        return $ext[count($ext)-1];
    return '';
}
function getMime($ext){
    include('boot/mime_types.php');
    if (!array_key_exists($ext,$mimeTypes))
       $mime = 'application/octet-stream';
    else
       $mime = $mimeTypes[$ext];
    return $mime;
}

$url = str_replace('/public', '', query_path());
$ext = getExt($url);
$mime = getMime($ext);

function getFile($url){
    $hostDir = BuCore::fstab('staticHostDir').'/'.HTTP_HOST;
    $prjDir = BuCore::fstab('staticPrj');
    $coreDir = BuCore::fstab('staticCore');
    foreach(array($hostDir,$prjDir,$coreDir) as $v)
        if(file_exists($v.$url))
            return $v.$url;

}

$file = getFile($url);
if($file){
    $fp = fopen($file, 'rb');
    header("Content-Type: ".$mime);
    header("Content-Length: " . filesize($file));
    fpassthru($fp);
}else{
    header("HTTP/1.0 404 Not Found");
    exit;
}
?>
