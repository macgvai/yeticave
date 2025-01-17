
    <nav class="nav">
        <ul class="nav__list container">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($category as $key => $element): ?>
                <li class="nav__item">
                    <a class="" href="pages/all-lots.html"><?=$element['category_name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($bets as $key => $bet): ?>
                <tr class="rates__item">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?=$bet['image']?>" width="54" height="40" alt="<?=$bet['category_name']?>">
                        </div>
                        <h3 class="rates__title"><a href="./main-lot.php?id=<?=$bet['id']?>"><?=$bet['title']?></a></h3>
                    </td>
                    <td class="rates__category">
                        <?=$bet['category_name']?>
                    </td>
                    <td class="rates__timer">
                        <?= $res = timeLeft($bet['time_expired']) ?>
                        <div class="timer <?php if ($res[0] < 1): ?>timer--finishing<?php endif; ?>"">

                        <?="$res[0]:$res[1]"?>
                        </div>
                    </td>
                    <td class="rates__price">
                        <?=$bet['cost']?>
                    </td>
                    <td class="rates__time">
                        5 минут назад
                    </td>
                </tr>

            <?php endforeach; ?>



        </table>
    </section>

