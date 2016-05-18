<div class="container">
    <button style="background-color: cornflowerblue"><a href="/admin/update/?id=<?php echo $news->id;?>">Изменить</a></button>
    <button style="background-color: red"><a href="/admin/delete/?id=<?php echo $news->id;?>">Удалить</a></button>
    <button style="background-color: aliceblue"><a href="/admin/">Вернуться</a></button>
        <div class="panel panel-success">
            <div class="panel-heading">
                    <h1> <?php echo $news->title; ?></h1>
            </div>
            <div class="panel-body"><?php echo $news->text; ?>
            </div>
            <div class="panel-footer" style="font-size: small"><p><b>Автор
                        : </b><i> <?php echo $article->author->firstname . ' ' . $article->author->lastname; ?></i></p>
                <p><b>Опубликовано: <?php echo $article->published; ?></b></p>
            </div>
        </div>
</div>