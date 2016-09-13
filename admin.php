<?php
require ("config.php");
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

if ($action != "login" && $action != "logout" && !$username) {
    login();
    exit();
}
switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'newArticle':
        newArticle();
        break;
    case 'editArticle':
        editArticle();
        break;
    case 'deleteArticle':
        deleteArticle();
        break;
    default:
        listArticles();
}

function login() {
    $results = array();
    $results['pageTitle'] = 'Admin Login | Widget News';
    if (isset($_POST['login'])) {
        // Пользователь получает форму ввода: попытка авторизовать пользователя
        if ($_POST['login'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {
            // Успешный вход: создаем сессию и перенаправляем а страницу админа
            $_SESSION['username'] = ADMIN_USERNAME;
            header("Location: admin.php");
        } else {
            // ошибка входа, выводим сообщение об ошибке
            $results['errorMessage'] = "Неправильный логин или пароль";
            require (TEMPLATE_PATH . "admin/loginForm.php");
        }
    } else {
        // Пользователь еще не получчил форму, выводим форму
        require (TEMPLATE_PATH . "/admin/loginForm.php");
    }
}
function logout() {
    unset($_SESSION['username']);
    header("Location: admin.php");
}
function newArticle() {
    $results = array();
    $results['pageTitle'] = "New Article";
    $results['formAction'] = "newArticle";

    if (isset($_POST['saveChanges'])) {
        // Пользовател получает форму редактирования статьи: сохроняем статью
        $article = new Article;
        $article->storeFormValues($_POST);
        $article->insert();
        header("Location: admin.php?status=changesSaved");
    } elseif (isset($_POST['cancel'])) {
        // Пользователь сбросил данные: возврщаемся к списку статей
        header("Location: admin.php");
    } else {
        // Пользователь еще не получил форму, выводим ее
        $results['article'] = new Article;
        require (TEMPLATE_PATH . "/admin/editArticle.php");
    }
}
function editArticle() {
    $results = array();
    $results['pageTitle'] = "Редактировать статью";
    $results['formAction'] = "editArticle";

    if (isset($_POST['saveChanges'])) {
        // пользователь получил форму редактирования: сохраняем статью

        if (!$article = Article::getById((int)$_POST['articleId'])) {
            header("Location: admin.php?error=articleNotFound");
            return;
        }
        $article->storeFormValues($_POST);
        $article->update();
        header("Location: admin.php?status=changesSaves");
    } elseif (isset($_POST['cancel'])) {
        // пользователь отказался от редактировании статьи, возвращаемся к списку статей
        header("Location: admin.php");
    } else {
        // Пользователь еще не получил форму, выводим форму
        $results['article'] = Article::getById((int)$_GET['articleId']);
        require (TEMPLATE_PATH . "/admin/editArticle.php");
    }
}
function deleteArticle() {
    if (!$article = Article::getById((int)$_GET['articleId'])) {
        header("Location: admin.php?error=articleNotFound");
        return;
    }
    $article->delete();
    header("Location: admin.php?status=articleDeleted");
}
function listArticles() {
    $results = array();
    $data = Article::getList();
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "All Articles";

    if (isset($_GET['error'])) {
        if ($_GET['error'] == "articleNotFound") {
            $results['errorMessage'] = "Ошибка, Статья не найдена";
        }
        if (isset($_GET['status'])) {
            if ($_GET['status'] == "changesSaved") {
                $results['statusMessage'] = "Ваши изменения сохранены";
            }
            if ($_GET['status'] == "articleDeleted") {
                $results['statusMessage'] = "Статья удалена";
            }
        }
        require (TEMPLATE_PATH . "/admin/listArticles.php");
    }
}
?>