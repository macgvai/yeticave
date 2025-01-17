<main>
    <section class="lot-item container">
        <h2><?=$title?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$image?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=$category?></span></p>
                <p class="lot-item__description"><?=$description?></p>
            </div>
            <div class="lot-item__right">
                <?php if ($is_auth): ?>
                    <div class="lot-item__state">
                        <?php $res = timeLeft($time_expired) ;?>

                        <div class="lot-item__timer timer <?php if ($res[0] < 1): ?>timer--finishing<?php endif; ?>"">

                            <?="$res[0]:$res[1]"?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?=$current_price . 'р'?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?=$current_price . 'р'?></span>
                            </div>
                        </div>
                        <form class="lot-item__form" action="./main-lot.php?id=<?= $id;?>" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item form__item--invalid">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="12 000">
<!--                                <span class="form__error">Введите наименование лота</span>-->
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                <?php endif; ?>

                <div class="history">
                    <h3>История ставок (<span><?=count($history)?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($history as $key => $element): ?>
                            <tr class="history__item">
                                <td class="history__name"><?=$element['name']?></td>
                                <td class="history__price"><?=$element['price_bet']?></td>
                                <td class="history__time"><?=$element['date_bet']?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
