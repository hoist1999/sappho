<?php

/*********************************
 * GET GLOBAL VARS AND FUNCTIONS *
 *********************************/
require_once "../global.php";



if (!empty($_POST["edit"])) {

    $image_id = clean($_POST["edit"]);
    $title    = clean($_POST["title"]);
    $caption  = clean($_POST["caption"]);
    $sql = "UPDATE photo_image          ".
           "SET title='$title',         ".
           "    caption='$caption'      ".
           "WHERE image_id='$image_id'  ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: images.php");

};



if (!empty($_GET["edit"])) {

    $image_id = clean($_GET["edit"]);
    $sql = "SELECT image_id,            ".
           "       filename,            ".
           "       title,               ".
           "       caption,             ".
           "       thumb_width,         ".
           "       thumb_height         ".
           "FROM photo_image            ".
           "WHERE image_id='$image_id'  ";
    if (!$result = mysql_query($sql)) print_error();
    $image = mysql_fetch_array($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
    <title><?php echo $sappho_title; ?> &mdash; manage &mdash; images</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <style type="text/css">
            @import "<?php echo $sappho_path; ?>/style.css";
        </style>
    </head>
    <body>
        <div id="container">
            <h1><a href="<?php echo $sappho_path; ?>/manage/"><?php echo $sappho_title; ?> management</a></h1>
            <h2><a href="images.php">images</a> &raquo; editing <i><?php echo $image["title"]; ?></i></h2>
            <div id="edit_image_thumbnail">
<?php

    $x = $image["thumb_width"];
    $y = $image["thumb_height"];
    $x_pad = ($x < $thumbnail_size) ? ($thumbnail_size-$x)/2 : 0;
    $y_pad = ($y < $thumbnail_size) ? ($thumbnail_size-$y)/2 : 0;

    echo "                <img src=\"http://$s3_bucket.s3.amazonaws.com/$s3_path/c/{$image["filename"]}.jpg\" alt=\"{$image["title"]}\" style=\"margin: {$y_pad}px {$x_pad}px;\"/>";

?>
            </div>
            <div id="edit">
                <form action="images.php" method="post">
                    <input type="text" name="title" value="<?php echo $image["title"]; ?>" /><br />
                    <textarea name="caption" rows="8"><?php echo $image["caption"]; ?></textarea><br />
                    <input type="hidden" name="edit" value="<?php echo $image["image_id"]; ?>" />
                    <input type="submit" />
                </form>
            </div>
        </div>
    </body>
</html>
<?php

    die();

};



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
    <title><?php echo $sappho_title; ?> &mdash; manage &mdash; photos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <style type="text/css">
            @import "<?php echo $sappho_path; ?>/style.css";
        </style>
    </head>
    <body>
        <div id="container">
            <h1><a href="<?php echo $sappho_path; ?>/manage/"><?php echo $sappho_title; ?> management</a></h1>
            <h2>images</h2>
            <div id="insert"><a href="import.php">import images</a></div>
            <div id="list">
                <table>
                    <tr>
                        <th>image_id</th>
                        <th>set_id</th>
                        <th>filename</th>
                        <th>title</th>
                        <th>edit</th>
                    </tr>
<?php

$sql = "SELECT photo_image.image_id,                    ".
       "       photo_image.set_id,                      ".
       "       photo_image.filename,                    ".
       "       photo_image.title                        ".
       "FROM photo_image                                ";
if (!$result = mysql_query($sql)) print_error();
while ($image = mysql_fetch_array($result)) {
    echo "                    <tr>\n";
    echo "                        <td>{$image["image_id"]}</td>\n";
    echo "                        <td>{$image["set_id"]}</td>\n";
    echo "                        <td>{$image["filename"]}</td>\n";
    echo "                        <td>{$image["title"]}</td>\n";
    echo "                        <td><a href=\"images.php?edit={$image["image_id"]}\">edit</a></td>\n";
    echo "                    </tr>\n";
};

?>
                </table>
            </div>
        </div>
    </body>
</html>
