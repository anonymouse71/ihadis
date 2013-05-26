<?php
/**
 * @file
 * custom_image_style.features.inc
 */

/**
 * Implements hook_image_default_styles().
 */
function custom_image_style_image_default_styles() {
  $styles = array();

  // Exported image style: blog_teaser.
  $styles['blog_teaser'] = array(
    'name' => 'blog_teaser',
    'effects' => array(
      1 => array(
        'label' => 'Scale and crop',
        'help' => 'Scale and crop will maintain the aspect-ratio of the original image, then crop the larger dimension. This is most useful for creating perfectly square thumbnails without stretching the image.',
        'effect callback' => 'image_scale_and_crop_effect',
        'dimensions callback' => 'image_resize_dimensions',
        'form callback' => 'image_resize_form',
        'summary theme' => 'image_resize_summary',
        'module' => 'image',
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => '700',
          'height' => '320',
        ),
        'weight' => '1',
      ),
    ),
  );

  // Exported image style: portfolio_item.
  $styles['portfolio_item'] = array(
    'name' => 'portfolio_item',
    'effects' => array(
      2 => array(
        'label' => 'Scale and crop',
        'help' => 'Scale and crop will maintain the aspect-ratio of the original image, then crop the larger dimension. This is most useful for creating perfectly square thumbnails without stretching the image.',
        'effect callback' => 'image_scale_and_crop_effect',
        'dimensions callback' => 'image_resize_dimensions',
        'form callback' => 'image_resize_form',
        'summary theme' => 'image_resize_summary',
        'module' => 'image',
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => '460',
          'height' => '290',
        ),
        'weight' => '1',
      ),
    ),
  );

  // Exported image style: portfolio_view.
  $styles['portfolio_view'] = array(
    'name' => 'portfolio_view',
    'effects' => array(
      3 => array(
        'label' => 'Scale and crop',
        'help' => 'Scale and crop will maintain the aspect-ratio of the original image, then crop the larger dimension. This is most useful for creating perfectly square thumbnails without stretching the image.',
        'effect callback' => 'image_scale_and_crop_effect',
        'dimensions callback' => 'image_resize_dimensions',
        'form callback' => 'image_resize_form',
        'summary theme' => 'image_resize_summary',
        'module' => 'image',
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => '940',
          'height' => '450',
        ),
        'weight' => '1',
      ),
    ),
  );

  return $styles;
}
