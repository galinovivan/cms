<?php include "templates/include/header.php" ?>
<div class="admin_header">
    <h2>widget news admin</h2>
    <p>Вы вошли как <?php echo htmlspecialchars($_SESSION['username'])?></p>
    <a href="admin.php?action=logout">Выйти</a>
</div>
<div class="admin_article">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php echo $results['pageTitle'] ?></h1>
            </div>
            <div class="col-md-12 admin_edit_form">
                <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
                    <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>" />
                    <?php if (isset($results['errorMessage'])) { ?>
                        <div class="error_message"><?php echo $results['errorMessage'] ?> </div>
                    <?php } ?>
                    <label for="title">Загаловок статьи</label>
                    <input type="text" name="title" id="title" placeholder="Заголовок статьи" required
                           value="<?php echo htmlspecialchars($results['article']->title) ?>" />
                    <label for="summary">Краткое описание</label>
                    <textarea name="summary" id="summary" cols="30" rows="8">
                        <?php echo htmlspecialchars($results['article']->summary) ?>
                    </textarea>
                    <label for="content">Содержпгте статьи</label>
                    <textarea name="content" id="content" cols="30" rows="10">
                        <?php echo htmlspecialchars($results['article']->content) ?>
                    </textarea>
                    <label for="publicationDate">
                        Дата публикации
                    </label>
                    <input type="date" name="publicationDate" id="publicationDate"
                           value="<?php echo $results['article']->publicationDate ? date("Y-m-d",$results['article']->publicationDate)
    : "" ?>" />
                    <input type="submit" name="saveChanges" value="Сохранить">
                    <input type="submit" formnovalidate name="cancel" value="Отменить">
                </form>
            </div>
            <?php if ($results['article']->id) { ?>
            <div class="col-md-12">
                <a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>"
                   class="btn-danger" id="delete_article">
                    Удалить статью
                </a>
            </div>
            <?php } ?>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#delete_article').click(function() {
            confirm('Удалить эту статью?');
        })
    })
</script>
<?php include "templates/include/footer.php" ?>