<?php
if (empty($title)) {
  $title = t('Recent Work');
}
?>
<div class="container">


  <div class="sixteen columns">
    <!-- Headline -->
    <div class="headline no-margin"><h3><?php print $title; ?></h3></div>
  </div>


  <?php foreach ($nodes as $node): ?>
    <div class="four columns">
      <?php $field_image = field_get_items('node', $node, 'field_image'); ?>
      <div class="picture"><a href="<?php print url('node/' . $node->nid); ?>"><?php print theme('image_style', array('style_name' => 'portfolio_item', 'path' => $field_image[0]['uri'])); ?><div class="image-overlay-link"></div></a></div>
      <div class="item-description">
        <h5><?php print l($node->title, 'node/' . $node->nid); ?></h5>
        <?php
        $body = field_get_items('node', $node, 'body');
        if (!empty($body)) {
          print custom_trim_text(array('max_length' => 60), $body[0]['value']);
        }
        ?>
      </div>
    </div>

  <?php endforeach; ?>


</div>