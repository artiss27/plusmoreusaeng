<?php
// in site/wp-content/themes/generatepress/404.php make - require get_template_directory() . '/custom/referal-link.php';
// in site/wp-content/themes/generatepress/sidebar.php make - if (defined('IS_REFERAL_PAGE')) return;

if (!defined('ABSPATH')) {
    die(); // Exit if accessed directly.
}

global $wpdb;
$arrUrl = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
$memberName = (!empty($_GET['u']) ? $_GET['u'] : (isset($arrUrl[2]) ? $arrUrl[2] : ''));

if ($memberName) $member = $wpdb->get_row("SELECT * FROM members WHERE username = '" . $memberName . "'", ARRAY_A);

if (empty($member)) return;

$_GET['u'] = $memberName;
$_GET['SPONSOR_ID'] = $member['member_id'];
if (empty($_COOKIE['reflink'])) {
    setcookie("reflink", $memberName, time() + 31556926, '/'); // One Year
}

add_filter('pre_get_document_title', function ($title) {
    global $wpdb;
    if (is_404() && !empty($_GET['SPONSOR_ID'])) {
        $member = $wpdb->get_row("SELECT * FROM members WHERE member_id = " . (int)$_GET['SPONSOR_ID'], ARRAY_A);
        return $member['first_name'] . ' ' . $member['last_name'] . ' | PlusMoreUsa – Real Financial Services';
    }
    return $title;
});

ob_start();
get_header();
$header = ob_get_clean();
preg_match('/<img.+src="(.+whitePMULOGO.+)".+class="(.+)"/Ui', $header, $matches);
if (isset($matches[1], $matches[2])) {
    $header = str_replace($matches[1], "/media/avatars/normal/" . (int)$_GET['SPONSOR_ID'] . ".jpg", $header);
    $header = str_replace($matches[2], $matches[2] . ' referal-logo', $header);
}
echo $header; ?>

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
        echo apply_filters('the_content', $post->post_content);
        do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
  </div><!-- #primary -->

<?php
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer(); ?>

  <script>
    //var member = <?//= $_GET['SPONSOR_ID'] ?>//;
    //var element = document.querySelector('body img:first-child');
    //element.setAttribute("src", '/media/avatars/normal/' + member + '.jpg');
    //element.removeAttribute('srcset');
    //element.className += " referal-logo";
  </script>

<?php
die();