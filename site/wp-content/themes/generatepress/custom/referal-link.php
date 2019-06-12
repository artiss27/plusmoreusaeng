<?php
// in site/wp-content/themes/generatepress/404.php make - require get_template_directory() . '/custom/referal-link.php';
// in site/wp-content/themes/generatepress/sidebar.php make - if (defined('IS_REFERAL_PAGE')) return;

if (!defined('ABSPATH')) {
    die(); // Exit if accessed directly.
}

$arrUrl = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
$memberName = (isset($arrUrl[2]) ? $arrUrl[2] : '');

if ($memberName) {
    $query = $wpdb->prepare("
        SELECT * FROM members
        WHERE username = '" . $memberName . "'
      ");
    $row = $wpdb->get_row($query, ARRAY_A);
}

if (!$row) return;

$_GET['u'] = $memberName;
if (empty($_COOKIE['reflink'])) {
    setcookie("reflink", $memberName, time() + 31556926, '/'); // One Year
}
define("REFERAL_ID", $row['member_id']);


get_header(); ?>
  <style>
    #page {
      max-width: 100%;
    }
    .referal-logo {
      border-radius: 50% !important;
      max-width: 75% !important;
    }
  </style>
  <div id="primary">
    <main id="main">
        <?php do_action('generate_before_main_content');
        $post = get_page_by_title('home');
        $content = apply_filters('the_content', $post->post_content);
        echo $content;
        do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
  </div><!-- #primary -->

<?php
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer(); ?>

<script>
  var member = <?= REFERAL_ID ?>;
  var element = document.querySelector('body img:first-child');
  element.setAttribute("src", '/media/avatars/normal/' + member + '.jpg');
  element.removeAttribute('srcset');
  element.className += " referal-logo";
</script>

<?php
die();