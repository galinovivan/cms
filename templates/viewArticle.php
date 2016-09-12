<?php include "templates/include/header.php";?>

<h1 style="width: 75%"><?php echo htmlspecialchars($results['article']->title)?></h1>
<div style="width: 75%;"><?php htmlspecialchars($results['article']->summary) ?></div>
<div style="width: 75%;"><?php htmlspecialchars($results['article']->content)?></div>
<p class="pubDate">Опубликована:
    <?php echo date('j F Y', $results['article']->publicationDate)?>
</p>
<p>
    <a href="./">Возвратиться на главную</a>
    <?php
    include "templates/include/footer.php"
    ?>
</p>
