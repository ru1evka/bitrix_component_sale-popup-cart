<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_IMAGE_URL", "PROPERTY_DATE_ACTIVE", "PROPERTY_DATE_DISABLE", "PROPERTY_ACTIVE_FORM");
$arFilter = Array("IBLOCK_ID"=>IntVal($arParams['ID_IBLOCK']), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ACTIVE_FORM"=>false);
$res = CIBlockElement::GetList(Array("SORT"=>"sort"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
    $arResult[] = $arFields;
}
?>