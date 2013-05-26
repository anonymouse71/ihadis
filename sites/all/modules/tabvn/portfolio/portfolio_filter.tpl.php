<div class="container">
  <div class="sixteen columns">
    <?php
    $terms = array();
    $vid = NULL;
    $vid_machine_name = 'portfolio_categories';
    $vocabulary = taxonomy_vocabulary_machine_name_load($vid_machine_name);
    if (!empty($vocabulary->vid)) {
      $vid = $vocabulary->vid;
    }
    if (!empty($vid)) {
      $terms = taxonomy_get_tree($vid);
    }
    ?>
    <div id="filters">
      <ul class="option-set" data-option-key="filter">
        <li><a href="#filter" class="selected" data-option-value="*"><?php print t('All'); ?></a></li>
        <?php if (!empty($terms)): ?>
          <?php foreach ($terms as $term): ?> 
            <li><a href="#filter" data-option-value=".tid-<?php print $term->tid; ?>"><?php print $term->name; ?></a></li>
          <?php endforeach; ?>
        <?php endif; ?>

      </ul>
    </div>

  </div>
</div>