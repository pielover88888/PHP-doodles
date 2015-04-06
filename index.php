<form action="/todo/index.php" method="POST">
<input type="text" placeholder="Name" name="new-todo"><br>
<textarea type="text" placeholder="desc" name="desc"></textarea><br>
<input type="submit" value="add new todo">
</form>

<?php
$didnothing = "no";
if(isset($_POST["new-todo"])){
$neww = $_POST["new-todo"];
if($neww != "index.php" && $neww != ".git"){
 $myfile = fopen(htmlspecialchars($_POST["new-todo"]), "w") or die("Unable to open file!");
 $txt = htmlspecialchars($_POST["desc"]);
 fwrite($myfile, $txt);
 fclose($myfile);
 echo "Made new file! check top of list!<br>";
} else {
echo "..really?<br>";
}

} else {
if(isset($_POST["del-todo"])){
echo "Deleted \"". $_POST["del-todo"] . "\"<br>";
$didnothing = "yes";
}
if($didnothing !== "yes"){
echo "Did nothing, new-todo was \$POST[\"new-todo\"] not set. this is a good thing unless you submitted the form<br>";
}
}

if(isset($_POST["del-todo"])){
$del = $_POST["del-todo"];
	if($del != "index.php"){
	unlink($del);
	}
	if($del != ".git"){ // I know, I know. I can do this better.
	unlink($del);
	}

}

?>
<?php
function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess','index.php','.git','php_errors.log');

    $files = array();
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

$scan_results = scan_dir(".");
$beg = "<a href=\"";
$end = "\">";

foreach($scan_results as $result){
$delbut = "<form style='display:inline;' action='/todo/index.php' method='POST'><input type='hidden' name='del-todo' value='$result'> <input style='border-radius:5000px;background-color:red;border-color:rgba(0,0,0,0.0);margin-left:10px;margin-top:-1px;' type='submit' value='x' title='Permanently delete $result'></form>";
		echo "<span style='background-color:rgba(0,0,0,0.05);'>" . $beg . $result . $end . $result . "</a>" . $delbut;
		echo "<pre style='margin-top:0px;background-color:rgba(0,0,0,0.05);'><code>" . file_get_contents($result) . "</code></pre></span>";
}
?>
<form action="/todo/index.php" method="POST">
<input type="text" placeholder="Name" name="del-todo">
<input type="submit" value="Permanently delete">
</form>
