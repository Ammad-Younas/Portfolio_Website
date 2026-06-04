<?php
// Custom PHP Website Functions (Polyfilling WP functions used in this template)

$doc_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$theme_dir = str_replace('\\', '/', dirname(__DIR__));
$base_url = str_replace($doc_root, '', $theme_dir);

define('BASE_URL', $base_url);
define('THEME_DIR', __DIR__ . '/..');

function get_header() {
    require_once THEME_DIR . '/includes/header.php';
}

function get_footer() {
    require_once THEME_DIR . '/includes/footer.php';
}

function home_url($path = '') {
    return BASE_URL . $path;
}

function esc_url($url) {
    return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
}

function esc_html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function esc_attr($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function esc_html_e($text, $domain = '') {
    echo esc_html($text);
}

function language_attributes() {
    echo 'lang="en"';
}

function bloginfo($show = '') {
    if ($show === 'charset') {
        echo 'UTF-8';
    }
}

function get_template_directory() {
    return THEME_DIR;
}

function wp_head() {
    $base_url = BASE_URL;
    $main_css_time = file_exists(THEME_DIR . '/assets/css/main.css') ? filemtime(THEME_DIR . '/assets/css/main.css') : time();
    echo <<<HTML
    <link rel="stylesheet" href="{$base_url}/assets/css/main.css?v={$main_css_time}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Outfit:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        var portfolio_ajax = {
            "ajax_url": "{$base_url}/includes/core/ajax.php"
        };
    </script>
HTML;
}

function body_class() {
    echo 'class=""';
}

function wp_body_open() {
    // Empty
}

function wp_footer() {
    $base_url = BASE_URL;
    $main_js_time = file_exists(THEME_DIR . '/assets/js/main.js') ? filemtime(THEME_DIR . '/assets/js/main.js') : time();
    echo <<<HTML
    <script src="{$base_url}/assets/js/main.js?v={$main_js_time}"></script>
HTML;
}

function sanitize_text_field($str) {
    return htmlspecialchars(strip_tags($str));
}

function sanitize_email($email) {
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

function sanitize_textarea_field($str) {
    return htmlspecialchars(strip_tags($str));
}

function is_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function wp_unslash($str) {
    return stripslashes($str);
}
