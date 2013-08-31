<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */

?>
<div id="node-<?php print $node->nid; ?>" class="post <?php print $classes; ?> clearfix"<?php print $attributes; ?>>

    <div class="post-content-hadith"<?php print $content_attributes; ?>>

        <?php if (!$page): ?>
            <h2<?php print $title_attributes; ?> class="blogTitle"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
        <?php endif; ?>

        <div class="post-description">

            <?php hide($content['comments']); hide($content['links']); ?>

            <?php if (!$page): ?>

                <!--<div class="hadith-teaser"><?php /*echo hadis_input_limit_text($node->field_arabic_hadith_body['und'][0]['safe_value'], 500); */?></div>-->
                <div class="hadith-teaser"><?php echo hadis_input_limit_text($body['und'][0]['safe_value'], 500); ?></div>

            <?php else: ?>

                <!-- Sections -->
                <div class="section-container">

                    <?php if (isset($content['field_international_hadith_num'])): ?>
                    <p class="section">International Hadith #<?php hadis_input_display_text($content['field_international_hadith_num']['#items'][0]['value']); ?></p>
                    <?php endif; ?>

                    <?php if (isset($content['field_section_arabic'])): ?>
                    <p class="section"><?php hadis_input_display_text($content['field_section_arabic']['#items'][0]['safe_value']); ?></p>
                    <?php endif; ?>

                    <?php if (isset($content['field_section_english'])): ?>
                    <p class="section"><?php hadis_input_display_text($content['field_section_english']['#items'][0]['safe_value']); ?></p>
                    <?php endif; ?>

                    <?php if (isset($content['field_section_bangla_primary'])): ?>
                    <p class="section"><?php hadis_input_display_text($content['field_section_bangla_primary']['#items'][0]['safe_value']); ?></p>
                    <?php endif; ?>

                </div>

                <!-- Additional Texts -->
                <div class="additional-text-container">

                    <?php if (isset($content['field_additional_text_english'])): ?>
                    <p class="additional-text"><?php hadis_input_display_text($content['field_additional_text_english']['#items'][0]['safe_value']); ?></p>
                    <?php endif; ?>

                    <?php if (isset($content['field_additional_text_arabic'])): ?>
                    <p class="additional-text"><?php hadis_input_display_text($content['field_additional_text_arabic']['#items'][0]['safe_value']); ?></p>
                    <?php endif; ?>

                    <?php if (isset($content['field_additional_text_bangla_pri'])): ?>
                    <p class="additional-text"><?php hadis_input_display_text($content['field_additional_text_bangla_pri']['#items'][0]['safe_value']); ?></p>
                    <?php endif; ?>

                </div>

                <!-- Main Body -->
                <p class="hadith-body body-arabic"><?php hadis_input_display_text($content['field_arabic_hadith_body']['#items'][0]['safe_value']); ?></p>

                <ul class="tabs-nav">
                    <li class="active"><a href="#bangla">Bangla Translation</a></li>
                    <li><a href="#english">English Translation</a></li>
                </ul>

                <div class="tabs-container">

                    <div class="tab-content" id="bangla" style="display: block;">
                        <p><?php hadis_input_display_text($content['field_bangla_pri_hadith_body']['#items'][0]['safe_value']); ?></p>
                        <?php if (!empty($content['field_bangla_pri_hadith_note']['#items'][0]['safe_value'])): ?>
                        <p class="footnote"><?php hadis_input_display_text($content['field_bangla_pri_hadith_note']['#items'][0]['safe_value']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="tab-content" id="english" style="display: none;">
                        <?php hadis_input_display_text($content['field_english_hadith_body']['#items'][0]['safe_value']); ?>
                    </div>

                </div>

            <?php endif; ?>

        </div>

        <?php if (!$page): ?>
            <a href="<?php print $node_url; ?>" class="post-entry"><?php print t('বিস্তারিত দেখুন'); ?></a>
        <?php endif; ?>

    </div>

</div>
