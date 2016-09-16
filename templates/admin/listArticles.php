<?php include "templates/include/header.php" ?>
<div class="admin_header">
    <h2>widget news admin</h2>
    <p>Вы вошли как <?php echo htmlspecialchars($_SESSION['username'])?></p>
    <a href="admin.php?action=logout">Выйти</a>
</div>
<h1>Все статьи</h1>
<?php if (isset($results['errorMessage'])) { ?>
<div class="error_message"><?php echo $results['errorMessage'] ?> </div>
<?php } ?>

<?php if (isset($results['statusMessage'])) { ?>
<div class="status_message">
    <?php echo $results['statusMessage'] ?>
</div>
<?php } ?>
<div class="container">
<div class="admin_article_list">
    <div class="row">
        <?php foreach ($results['articles'] as $article) { ?>
        <div class="col-md-3">
            <a href="admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>">
                <div class="article_date">
                    <span><?php echo date('j M Y', $article->publicationDate)?></span>
                    <div class="article_title">
                        <span><?php echo $article->title ?></span>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="total_rows">
                <p><?php echo $results['totalRows'] . "статей" ?><?php echo ($results['totalRows'] != 1) ? 's' : '' ?>Всего</p>
                <p><a href="admin.php?action=newArticle" class="btn">Добавить новую статью</a></p>
            </div>
        </div>
    </div>
    </div>
</div>
<?php include "templates/include/footer.php" ?>
