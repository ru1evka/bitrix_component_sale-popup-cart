<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
    "GROUPS" => array(), // Группы пока пустые
    "PARAMETERS" => array(
        "ID_IBLOCK" => array(
            "PARENT" => "BASE",
            "NAME" => "ID Инфоблока",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "ID_FORM" => array(
            "PARENT" => "BASE",
            "NAME" => "ID формы",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "DATE_ACTIVE" => array(
            "PARENT" => "BASE",
            "NAME" => "Дата начала акции",
            "TYPE" => "DATETIME",
            "DEFAULT" => date("d-m-Y H:i:s"),
        ),
        "DATE_DISABLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Дата окончания акции",
            "TYPE" => "DATETIME",
            "DEFAULT" => "",
        ),
        "IMAGE_URL" => array(
            "PARENT" => "BASE",
            "NAME" => "URL изображения",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "TITLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Заголовок формы",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "SUB_TITLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Под заголовок",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        )
    ),
);
?>