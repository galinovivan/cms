<?php
require ("config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";
switch ($action) {
    case 'archive':
        archive();
        break;
    case 'viewAticle':
        viewArticle();
        break;
    default:
        homePage();
}

function archive() {
    $results = array();
    $data = Article::getList();
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Article Archive | Widget news";
    require (TEMPLATE_PATH . "/archive.php");
}
function viewArticle() {
    if (!isset($_GET["articleId"]) || !$_GET["srticleId"]) {
        homepage();
        return;
    } else {
        $results = array();
        $results['article'] = Article::getById((int)$_GET["articleId"]);
        $results['pageTitle'] = $results['article']->title . " | Widget News";
        require (TEMPLATE_PATH . "/viewArticle.php");
    }
}
function homePage() {
    $results = array();
    $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Widget News";
    require (TEMPLATE_PATH . "/homepage.php");
}
?>

