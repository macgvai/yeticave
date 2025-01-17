<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($category as $key => $element): ?>
                <li class="promo__item promo__item--<?=$element['category_code'] ?>">
                    <a class="promo__link" href="pages/all-lots.html"><?=$element['category_name'] ?></a>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
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
</main>
