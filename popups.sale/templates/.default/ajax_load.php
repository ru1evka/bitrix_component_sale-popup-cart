<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
ob_end_clean(); 
header('Content-Type: application/json');
CModule::IncludeModule("iblock");
$arSelect = Array("ID", "NAME", "PROPERTY_IMAGE_URL", "PROPERTY_DATE_ACTIVE", "PROPERTY_DATE_DISABLE");
$arFilter = Array("IBLOCK_ID"=>IntVal($_POST['ID_IBLOCK']), 'ID' => $_POST['ID_ITEM'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");

$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
    $arFields['IMG_SRC'] = CFile::GetByID($arFields['PROPERTY_IMAGE_URL_VALUE'])->Fetch()["SRC"];
    $data = $arFields;
}
echo json_encode($data);
exit();
?>