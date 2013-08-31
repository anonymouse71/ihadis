<?php

    $chapters = hadis_input_get_chapter_collection($term->tid, true);

?>

    <div class="icon-box" style="margin-bottom: 20px; text-align: justify;">
        <i class="ico-book" style="margin-left: -12px;"></i>
        <h3><?php echo $term->name ?></h3>
        <p><?php echo $term->description ?></p>
    </div>

<?php

    foreach ($chapters as $chapterId => $chapter):

        $uri = taxonomy_term_uri($chapter);
        $title = taxonomy_term_title($chapter);
        $link = l($title, $uri['path']);

?>

    <div class="book-chapter"><?php echo $link ?></div>

<?php endforeach ?>