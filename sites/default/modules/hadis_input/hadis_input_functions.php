<?php

define('TAG_VOCABULARY', 1);
define('BOOK_VOCABULARY', 3);
define('CHAPTER_VOCABULARY', 4);

/**
 * Returns the terms from the Hadith Book vocabulary
 *
 * @return array
 */
function hadis_input_get_hadith_book_collection()
{
    $hadithBookCollection = array();

    foreach (taxonomy_get_tree(BOOK_VOCABULARY) as $term) {
        $hadithBookCollection[$term->tid] = $term->name;
    }

    reset($hadithBookCollection);
    return $hadithBookCollection;
}

/**
 * Returns the terms from the Chapter vocabulary based on specified parent
 *
 * @param $hadithBookId int Term Id of the Hadith Book taxonomy
 * @param bool $details
 *
 * @return array
 */
function hadis_input_get_chapter_collection($hadithBookId, $details = false)
{
    // TODO: Use the entity query to remove manual configuration

    /*$query = new EntityFieldQuery();
    $entities = $query->entityCondition('entity_type', 'taxonomy_term')
                ->propertyCondition('vid', '4')
                ->fieldCondition('field_section_book', 'tid', array('1'), 'IN')
                ->execute();

    var_dump($entities);*/

    $parentTermId = include_once dirname(__FILE__) . '/hadis_input_book_mapping.php';
    $chapterCollection = array();

    foreach (taxonomy_get_tree(CHAPTER_VOCABULARY, $parentTermId[$hadithBookId]) as $term) {
        $chapterCollection[$term->tid] = ($details) ? $term : $term->name;
    }

    return $chapterCollection;
}


function hadis_input_get_sections_by_chapter($chapterId)
{
    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', 'hadith')
        ->fieldCondition('field_hadith_book_chapter', 'tid', $chapterId);

    $result = $query->execute();

    if (empty($result['node'])) {
        return array();
    }

    $nodes = entity_load('node', array_keys($result['node']));
    $sections = array();

    foreach ($nodes as $node) {
        if (!in_array($node->field_section_bangla_primary['und'][0]['value'], $sections)) {
            $sections[] = $node->field_section_bangla_primary['und'][0]['value'];
        }
    }

    return $sections;
}

function hadis_input_get_primary_bangla_book($bookId)
{
    switch ($bookId) {
        case 1: return "Islamic Foundation";
        case 2: return "Islamic Foundation";
    }
}

function hadis_input_get_secondary_bangla_book($bookId)
{
    switch ($bookId) {
        case 1: return null;
        case 2: return null;
    }
}

function hadis_input_create_term($tag)
{
    $term = array('vid' => 1, 'name' => $tag);
    $term = (object)$term;

    taxonomy_term_save($term);
    $tid = $term->tid;

    return $tid;
}

function hadis_input_get_title($data, $termBook, $termChapter)
{
    $title = $termBook->name . ', ';
    $title .= substr($termChapter->name, strpos($termChapter->name, ' ') + 1) . ', ';
    $title .= 'হাদিস ' . hadis_input_get_bangla_number($data['field_bangla_pri_hadith_num']);

    return $title;
}

function hadis_input_get_bangla_number($number)
{
    $engArray = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
    $bangArray = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');

    $converted = str_replace($engArray, $bangArray, $number);
    return $converted;
}

function hadis_input_limit_text($text, $len) {

    if (mb_strlen($text) < $len) {
        return $text;
    }

    $text_words = explode(' ', $text);
    $out = null;

    foreach ($text_words as $word) {

        if ((mb_strlen($word) > $len) && $out == null) {
            return mb_substr($word, 0, $len) . "...";
        }

        if ((mb_strlen($out) + mb_strlen($word)) > $len) {
            return $out . "...";
        }

        $out .= " " . $word;

    }

    return $out;
}

function hadis_input_display_text($text)
{
    echo nl2br($text);
}

function hadis_input_get_hadith_by_number($number, $book = 1)
{
    $query = new EntityFieldQuery();

    $query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', 'hadith')
    ->fieldCondition('field_bangla_pri_hadith_num', 'value', $number);

    $result = $query->execute();

    if (!empty($result['node'])) {

        $nodeIds = array_keys($result['node']);
        $nodes = entity_load('node', $nodeIds);

        return array_shift($nodes);

    }

    return false;
}
