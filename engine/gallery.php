<?php

function renderImg($file, $images)
{
    $gallery = '';
    foreach ($images as $image) {
        $gallery .= render($file, $image);
    }
    return $gallery;
}

function view_img($id, $file)
{
    $sql = "SELECT * FROM `images` WHERE id='$id'";
    $img_item = '';
    $img = getAssocResult($sql);
    foreach ($img as $img_item) {
        $view = $img_item['views'] + 1;
        $img_item['views'] = (string)$view;
        $update_views = "UPDATE `images` SET `views`='$view' WHERE `images`.`id`='$id'";
        execQuery($update_views);
    }
    $img = '';
    $img .= render($file, $img_item);
    return $img;
}