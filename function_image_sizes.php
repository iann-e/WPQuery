<?php

// use "theme_after_setup" instead of "init"
// "image_ " it will show as name in image sizes 
add_action( 'init', function(){


    //200 x 200 crop size of image
    add_image_size( 'image_small',  200, 200, true );
    // 500 x depends of the sizes of the image to scale
    add_image_size( 'name_of_image',  500 );

    // 200 x 1000 custom position to be cropped
    add_image_size( 'name_cool', 200, 1000, ['left', 'bottom'] );


} ) ;