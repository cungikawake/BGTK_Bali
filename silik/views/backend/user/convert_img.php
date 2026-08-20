<?php
$imgUrl = APPPATH . "../assets/images/ttd-sample.jpg";


# create new ImageMagick object from image url
$imagick = new Imagick($imgUrl);

# replace white background with fuchsia
$imagick->floodFillPaintImage("rgb(255, 0, 255)", 5000, "rgb(255,255,255)", 0 , 0, false);

#make fuchsia transparent
$imagick->transparentPaintImage("rgb(255,0,255)", 0, 5, false);

$imagick->setImageFormat('png');

$imagick->trimImage(20000);
# set resulting image format as png










/*
// Load the image
$imagick = new Imagick($imgUrl);

$backgroundColor = "rgb(255, 255, 255)";
$fuzzFactor = 0.1;

// Create a copy of the image, and paint all the pixels that
// are the background color to be transparent
$outlineImagick = clone $imagick;
$outlineImagick->transparentPaintImage($backgroundColor, 0, $fuzzFactor * Imagick::getQuantum(), false);

// Copy the input image
$mask = clone $imagick;
// Deactivate the alpha channel if the image has one, as later in the process
// we want the mask alpha to be copied from the colour channel to the src
// alpha channel. If the mask image has an alpha channel, it would be copied
// from that instead of from the colour channel.
$mask->setImageAlphaChannel(Imagick::ALPHACHANNEL_DEACTIVATE);
//Convert to gray scale to make life simpler
$mask->transformImageColorSpace(Imagick::COLORSPACE_GRAY);

// DstOut does a "cookie-cutter" it leaves the shape remaining after the
// outlineImagick image, is cut out of the mask.
$mask->compositeImage($outlineImagick,Imagick::COMPOSITE_DSTOUT, 0, 0);

// The mask is now black where the objects are in the image and white
// where the background is.
// Negate the image, to have white where the objects are and black for
// the background
$mask->negateImage(false);

$fillPixelHoles = false;

if ($fillPixelHoles == true) {
        // If your image has pixel sized holes in it, you will want to fill them
        // in. This will however also make any acute corners in the image not be
        // transparent.

        // Fill holes - any black pixel that is surrounded by white will become
        // white
    $mask->blurimage(2, 1);
    $mask->whiteThresholdImage("rgb(10, 10, 10)");

        // Thinning - because the previous step made the outline thicker, we
        // attempt to make it thinner by an equivalent amount.
    $mask->blurimage(2, 1);
    $mask->blackThresholdImage("rgb(255, 255, 255)");
}

//Soften the edge of the mask to prevent jaggies on the outline.
$mask->blurimage(2, 2);

// We want the mask to go from full opaque to fully transparent quite quickly to
// avoid having too many semi-transparent pixels. sigmoidalContrastImage does this
// for us. Values to use were determined empirically.
$contrast = 15;
$midpoint = 0.7 * Imagick::getQuantum();
$mask->sigmoidalContrastImage(true, $contrast, $midpoint);

// Copy the mask into the opacity channel of the original image.
// You are probably done here if you just want the background removed.
$imagick->compositeimage($mask,Imagick::COMPOSITE_COPYOPACITY, 0, 0);

// Copy the image with the background removed over it.
$imagick->compositeimage($imagick, Imagick::COMPOSITE_OVER, 0, 0);

// We eliminate empty areas to only leave objects
$imagick->trimImage(0);

// Maximum 500 height but the width can exceed 500 if the original image exceeds 500 somewhere
$imagick->resizeImage(0, 500, Imagick::FILTER_CATROM, 1);
*/

// We export as PNG
$imagick->setImageFormat('png');

# set header type as PNG image
header('Content-Type: image/png');

# output the new image
echo $imagick->getImageBlob();