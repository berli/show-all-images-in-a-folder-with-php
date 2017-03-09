<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Pagination.php";

/**
*
* Images management
*
* Configuration :
*   folderPath : path to image folder,
*   types : Supported images file types
*
*/

$imagesConfig = array(
    "folderPath" => "img/",
    "types" => "{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}"
);

# Images array list generation
$images = glob($imagesConfig["folderPath"].$imagesConfig["types"], GLOB_BRACE);

/**
 *
 * Sort images list
 *
 * @param    array $imagesList to sort
 * @param    bool  $sortByName to sort by date. Default false, images will be sorted by date
 * @param    bool  $newestsFirst if sorted by date, orderer by newests
 * @return    array $sortedImages
 *
 */
function sortImagesList(Array $imagesList, $sortByName = false, $newestsFirst = true){
    $sortedImages = array();
    if ($sortByName) {
        $sortedImages = natsort($imagesList);
    } else {
        # sort by 'last modified' time stamp
        $count = count($imagesList);
        for ($i = 0; $i < $count; $i++) {
            $sortedImages[date('YmdHis', filemtime($imagesList[$i])) . $i] = $imagesList[$i];
        }
        if ($newestsFirst) {
            krsort($sortedImages);
        } else {
            ksort($sortedImages);
        }
    }
    return $sortedImages;
}

/**
 *
 * Html images list rendering
 *
 * @param    array $imagesList to render
 * @return    void, echoes Html
 *
 */
function renderImagesHtml(Array $imagesList) {
    foreach ($imagesList as $image) {
        renderImageHtml($image);
    }
}

/**
 *
 * Html image rendering
 *
 * @param    string $image to render
 * @return    void, echoes Html
 *
 */
function renderImageHtml($image) {
    # Get image name without path and extension
    $imageName = basename($image);
    $imageName = pathinfo($imageName, PATHINFO_FILENAME);

    # Get 'last modified' date
    $lastModifiedDate = date('F d Y H:i:s', filemtime($image));

    $imageLabel = 'Image name: ' . $imageName;
    $lastModifiedLabel = '(last modified: ' . $lastModifiedDate . ')';
    $label = $imageLabel.' '.$lastModifiedLabel;

    # Begin addition
    echo <<<EOT
    <li class="ins-imgs-li">
        <div class="ins-imgs-img" onclick=this.classList.toggle("zoom");>
            <a name="$image" href="#$image ">
                <img src="$image" alt="$imageName" title="$imageName">
            </a>
        </div>
        <div class="ins-imgs-label">$label</div>
    </li>
EOT;
}

// sort images
$images = sortImagesList($images);
$htmlPagination = false;

// pagination
if (isset($_GET['page']) && is_numeric($_GET['page']) && ($_GET['page'] > 0)) {
    $Pagination  = new Pagination($images);
    $pageNumber = (int) $_GET['page'];
    // last page maximum value
    $pageNumber = ($pageNumber <= $Pagination->last) ? $pageNumber : $Pagination->last;
    $imagesToDisplay = $Pagination->getPageData($images, $pageNumber);
    $htmlPagination = $Pagination->renderPaginationHtml($pageNumber);
} else {
    $imagesToDisplay = $images;
}

# Action render images list with style
echo('<link rel="stylesheet" type="text/css" href="ins-imgs.css">');
echo('<ul class="ins-imgs">');
renderImagesHtml($imagesToDisplay);
echo('</ul>');
echo $htmlPagination;

?>
