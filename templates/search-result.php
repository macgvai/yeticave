

<nav class="nav">
      <ul class="nav__list container">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $key => $element): ?>
                <li class="nav__item">
                    <a class="" href="pages/all-lots.html"><?=$element['category_name'] ?></a>
                </li>
            <?php endforeach; ?>
      </ul>
</nav>
<div class="container">
    <section class="lots">
    <h2>Результаты поиска по запросу «<span><?=$search ?></span>»</h2>
    <ul class="lots__list">
        <?php foreach ($lots as $key => $element): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$element['image']?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$element['category_name']?></span>
                    <h3 class="lot__title"><a class="text-link" href="main-lot.php?id=<?=$element['id']?>"><?=$element['title']?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <?=getPrice($element['cost'])?>
                            <span class="lot__cost"><?=getPrice($element['cost'])?></span>
                        </div>
                    <div class="lot__timer timer">
                <?php $res = timeLeft(htmlspecialchars($element['time_expired'])) ;?>

                <?php if ($res < 1): ?>
                <div class="timer--finishing"><?="$res[0]:$res[1]"?><div>
                    <?php else : ?>
                    <div><?="$res[0]:$res[1]" ?><div>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>

    </ul>
    </section>
    <ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
    <li class="pagination-item pagination-item-active"><a>1</a></li>
    <li class="pagination-item"><a href="#">2</a></li>
    <li class="pagination-item"><a href="#">3</a></li>
    <li class="pagination-item"><a href="#">4</a></li>
    <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>


