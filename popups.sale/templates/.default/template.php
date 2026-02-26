<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<div style="display: none;" class="popup-container" id="popupContainer">
    <?if(count((array)$arResult) > 0){?>
        <div class="popup-list">
            <span onclick="toggle(this)" class="h4">У нас еще много акций &#8659;</span>
            <?foreach($arResult as $item){?>
                <div class="popup-list_item">
                    <div class="popup-list_item__link" onclick="getAjaxData(this)" title="<?= $item['NAME'] ?>" data-id="<?= $item['ID'] ?>" data-intervalid=""><?= $item['NAME'] ?></div>
                </div>
            <?}?>
        </div> 
    <?}?>
    <?if($arParams['ID_FORM'] != ''):?>
        <div class="popup-box">
            <?php if($arParams['TITLE'] != '') : ?>
                <div class="wrap_title">
                    <h4 class="title"><?=$arParams['TITLE']?></h4>
                </div>
            <?php endif; ?>
            <?php if($arParams['SUB_TITLE'] != '') : ?>
                <div class="wrap_title">
                    <p class="sub_title"><?=$arParams['SUB_TITLE']?></p>
                </div>
            <?php endif; ?>
            <?php if($arResult[0]['PROPERTY_IMAGE_URL_VALUE'] != '') : ?>
                <img src="<?= CFile::GetByID($arResult[0]['PROPERTY_IMAGE_URL_VALUE'])->Fetch()["SRC"] ?>" alt="Изображение акции"/>
            <?php endif; ?>
            <div class="wrap_countdown">
                <span class="wrap_countdown__title">Предложение ограничено:</span>
                <div id="countdown"></div>
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:form.result.new",
                "",
                Array(
                  "WEB_FORM_ID" => $arParams['ID_FORM'],
                  "AJAX_OPTION_STYLE" => "Y",
                  "IGNORE_CUSTOM_TEMPLATE" => "N",
                  "USE_EXTENDED_ERRORS" => "Y",
                  "SEF_MODE" => "N",
                  "VARIABLE_ALIASES" => Array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID"),
                  "CACHE_TYPE" => "N",
                  "CACHE_TIME" => "3600",
                  "LIST_URL" => "",
                  "EDIT_URL" => "",
                  "SUCCESS_URL" => "",
                  "CHAIN_ITEM_TEXT" => "",
                  "CHAIN_ITEM_LINK" => "",
                  "AJAX_MODE" => "Y"
                )
              );
            ?>
        </div>
    <?else:?>
        <div class="popup-box error">
            Параметр "ID формы" не указан!
        </div>
    <?endif;?>
</div>

<!-- Кнопка вызова окна -->
<a id="reminderButton" href="javascript:;" style="display: none;" class="gift-button <?=$USER->IsAuthorized()?'down':''?>" data-fancybox data-src="#popupContainer">
   <svg xmlns="http://www.w3.org/2000/svg" clip-rule="evenodd" fill-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 6773 6773">
        <g id="Layer_x0020_1">
            <circle cx="3387" cy="3387" fill="#00ab94" r="3387" style="fill: rgb(209, 26, 26);"/>
            <path d="m3796 2469v660h1543c54 0 97-44 97-97v-467c0-53-44-96-97-96zm1018 2932h-2854c-190 0-345-155-345-345v-1809h-181c-118 0-215-96-215-215v-467c0-118 97-215 215-215h432c47-155 147-228 285-272-101-110-151-228-106-397 59-221 288-353 509-294 291 78 510 373 703 687l259-1c193-313 412-608 704-686 221-60 449 72 509 293 45 169-5 288-106 398 137 43 237 116 285 272h431c119 0 215 97 215 215v467c0 119-96 215-215 215h-181v1809c0 190-154 345-344 345zm-1837-2272v-660h-1543c-53 0-96 43-96 96v467c0 54 43 97 96 97zm119 52v448c43-26 258-163 291-163 34 0 247 136 291 163v-1160h-582zm-1362 66v1809c0 125 101 226 226 226h1387l1693-1692v-343h-1244v486c0 46-50 74-89 51l-320-190-320 190c-40 23-89-4-90-51v-486zm2414 2035h666c125 0 226-101 226-226v-665zm-633 0h465l1060-1059v-466zm188-2932c0-91-53-158-140-158l-352 1c-86 0-141 65-141 157zm-751-28c4-109 76-200 174-234-174-277-514-738-828-557-69 40-118 104-139 181-36 134 1 223 148 353 36 32 21 93-27 103-167 34-247 83-289 182h960zm695-234c116 40 175 139 175 262h960c-42-99-122-148-288-182-48-10-65-70-28-102 147-130 184-220 148-354-42-159-205-253-364-210-237 63-430 312-603 586z" fill="#fff" style="fill: rgb(255, 255, 255);"/>
        </g>
    </svg>
</a>

<?php
$start_date_js = new DateTime($arResult[0]['PROPERTY_DATE_ACTIVE_VALUE']);
$end_date_js = new DateTime($arResult[0]['PROPERTY_DATE_DISABLE_VALUE']);

$start_timestamp = $start_date_js->format('U') * 1000; // timestamp в миллисекундах
$end_timestamp = $end_date_js->format('U') * 1000;     // timestamp в миллисекундах
?>

<script>
    $(document).ready(function(){
        $('input[name="form_text_30"]').val('Акция: <?= $arResult[0]['NAME'] ?>');
        $('input[name="form_text_30"]').text('Акция: <?= $arResult[0]['NAME'] ?>');
        var intervalId;

        // Получаем метки времени начала и окончания акции
        var startTimestamp = <?=$start_timestamp?>;
        var endTimestamp = <?=$end_timestamp?>;

        // Текущее время
        var currentTime = new Date().getTime();

        // Проверяем, находится ли текущая дата в рамках акции
        function isPromotionActive() {
            if(currentTime >= startTimestamp && currentTime <= endTimestamp){
                return true;    
            } else {
                return false;
            }
        }
        // Проверяем, прошел ли период, чтобы вновь показать акцию
        function shouldShowForm() {
            var lastVisit = localStorage.getItem('last_visit_time');
            var interval = 6 * 60 * 60 * 1000; // Интервал в миллисекундах (сутки)

            if(!lastVisit || (currentTime - lastVisit >= interval)) {
                localStorage.setItem('last_visit_time', currentTime); // Запоминаем последнее посещение
                return true;
            }
            return false;
        }

        // Показываем окно только если акция ещё активна
        if(isPromotionActive() && shouldShowForm()) {
            setTimeout(clickOpenForm, 3000); // Показывать окно через 3 секунды
        }

        if(isPromotionActive()) {
            $('#reminderButton').css({'display' : 'block'});
        }

        // Функция показа окна
        function clickOpenForm(){
            $('a.gift-button').click();
        }

        function padZero(num) {
            return num.toString().padStart(2, '0'); // Дополняем число слева нулём, если оно меньше двух знаков
        }

        // Таймер обратного отсчета
        var countDownDate = endTimestamp;

        intervalId = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24)); // Рассчитываем количество полных дней
                hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // Оставшиеся часы после дней
                minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)); // Минуты
                seconds = Math.floor((distance % (1000 * 60)) / 1000); // Секунды

                // Приводим числа к нужному формату с лидирующими нулями
                days = padZero(days);
                hours = padZero(hours);
                minutes = padZero(minutes);
                seconds = padZero(seconds);

                $("#countdown").html('<div class="timer">' +
                                        '<div class="timer_flex">' +
                                            '<span class="num">'+ days + '</span>' +
                                            '<span class="desc_num">дни</span>'+
                                        '</div> <span class="razdel">:</span>' +
                                        '<div class="timer_flex">' +
                                            '<span class="num">' + hours + '</span>'+
                                            '<span class="desc_num">часы</span>'+
                                        '</div> <span class="razdel">:</span>' +
                                        '<div class="timer_flex">' +
                                            '<span class="num">' + minutes + '</span>'+
                                            '<span class="desc_num">минуты</span>'+
                                        '</div> <span class="razdel">:</span>' +
                                        '<div class="timer_flex">' +
                                            '<span class="num">' + seconds + '</span>'+
                                            '<span class="desc_num">секунды</span>'+
                                        '</div>' +
                                    '</div>');

            if (distance < 0) {
                clearInterval(intervalId);
                $("#countdown").html("Акция закончилась");
            }
        }, 1000);
        
        $('.popup-list_item__link').data('intervalid' , intervalId);
        $('input[name="form_text_5"]').attr('type', 'tel').mask("+7 999 999 99 99");

        if($(window).width() <= 1400){
            $('.popup-list').addClass('collapsed');
        }
    });

    function getAjaxData(elem){
        $.ajax({
            method: "POST",
            url: "/local/components/advantika/popups.sale/templates/.default/ajax_load.php",
            dataType: 'json',
            data: { ID_ITEM: $(elem).data("id"), ID_IBLOCK: <?= $arParams['ID_IBLOCK'] ?> }
        }).done(function( data ) {
            $('#popupContainer .popup-box img').css({'opacity' : 0});
            setTimeout(function(){
                $('#popupContainer .popup-box img').attr('src', data.IMG_SRC);
                $('input[name="form_text_30"]').val('Акция: ' + data.NAME);
                $('input[name="form_text_30"]').text('Акция: ' + data.NAME);
            }, 400);
            setTimeout(function(){
                $('#popupContainer .popup-box img').css({'opacity' : 1});
            }, 700);
            if(data.PROPERTY_DATE_DISABLE_VALUE != null){
                $('.wrap_countdown span.wrap_countdown__title').html("Предложение ограничено:");
                // Разбираем строку вручную, учитывая российские форматы даты ДД.ММ.ГГГГ ЧЧ:ММ:СС
                const parts = data.PROPERTY_DATE_DISABLE_VALUE.split(/[\s.:]/).map(Number);
                if(!parts[3]){parts[3]=0};if(!parts[4]){parts[4]=0};if(!parts[5]){parts[5]=0};
                // Создаем новый экземпляр Date с нужными значениями (месяц начинается с нуля!)
                const parsedDate = new Date(parts[2], parts[1]-1, parts[0], parts[3], parts[4], parts[5]);
                // Получаем timestamp в миллисекундах
                var countDownDate = parsedDate.getTime();

                //Очишаем предыдуший запуск таймера и стартуем новый
                clearInterval($(elem).data("intervalid"));
                var intervalId = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;
                
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24)); // Рассчитываем количество полных дней
                        hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // Оставшиеся часы после дней
                        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)); // Минуты
                        seconds = Math.floor((distance % (1000 * 60)) / 1000); // Секунды

                        function padZero(num) {
                            return num.toString().padStart(2, '0'); // Дополняем число слева нулём, если оно меньше двух знаков
                        }
                        // Приводим числа к нужному формату с лидирующими нулями
                        days = padZero(days);
                        hours = padZero(hours);
                        minutes = padZero(minutes);
                        seconds = padZero(seconds);
                
                        $("#countdown").html('<div class="timer">' +
                                                '<div class="timer_flex">' +
                                                    '<span class="num">'+ days + '</span>' +
                                                    '<span class="desc_num">дни</span>'+
                                                '</div> <span class="razdel">:</span>' +
                                                '<div class="timer_flex">' +
                                                    '<span class="num">' + hours + '</span>'+
                                                    '<span class="desc_num">часы</span>'+
                                                '</div> <span class="razdel">:</span>' +
                                                '<div class="timer_flex">' +
                                                    '<span class="num">' + minutes + '</span>'+
                                                    '<span class="desc_num">минуты</span>'+
                                                '</div> <span class="razdel">:</span>' +
                                                '<div class="timer_flex">' +
                                                    '<span class="num">' + seconds + '</span>'+
                                                    '<span class="desc_num">секунды</span>'+
                                                '</div>' +
                                            '</div>');
                
                    if (distance < 0) {
                        clearInterval(intervalId);
                        $("#countdown").html("Акция закончилась");
                    }
                }, 1000);
                $('.popup-list_item__link').data('intervalid', intervalId);
            } else {
                clearInterval($(elem).data("intervalid"));
                $('.wrap_countdown span.wrap_countdown__title').html('Период проведения акции не назначен');
                $("#countdown").html("");
            }
            toggle($('#popupContainer span.h4'));
        });
    }

    function toggle(elem){
        var list = $(elem).parents('.popup-list');
            
        if (list.hasClass('collapsed')) {
            list.removeClass('collapsed');
        } else {
            list.addClass('collapsed');
        }
    }
    // Функция, вызываемая каждые 8 секунд
    function startShaking() {
        const btn = document.getElementById("reminderButton");
        btn.classList.add("shake");
        setTimeout(() => btn.classList.remove("shake"), 500); // Убираем класс через 0.5 секунды
    }
    // Запускаем регулярную проверку каждые 8 секунд
    setInterval(startShaking, 8000);
</script>
