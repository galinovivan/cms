<?php include "templates/include/header.php" ?>
<h1>Архив статей</h1>
<ul id="headlines">
    <?php
    foreach ($results['articles'] as $article) {
    ?>
    <li>
        <p>
            <span class="article_date">
                <?php echo date('j F Y', $article->publicationDate)?>
            </span>
            <a href=".?action=viewArticle$amp;articleId=<?php echo $article->id?>"><?php echo htmlspecialchars($article->title)?>
            </a>
        </p>

        <p class="summary">
            <?php echo htmlspecialchars($article->summary)
                ?>
        </p>
        </li>
    <?php } ?>
</ul>
<p>
    <?php echo $results['totalRows']?>article<?php echo ($results['totalRows'] != 1) ? 's' : '' ?>
    in total.
</p>
<p><a href="./">Возвратиться на домашнюю страницу</a></p>
<?php include "templates/include/footer.php" ?>
