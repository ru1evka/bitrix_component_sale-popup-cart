<?
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
class CPopupsSale extends CBitrixComponent
{
	// Подготавливаем параметры компонента
	public function onPrepareComponentParams($arParams)
	{
		$arParams = array(
			"ID_FORM" => $arParams['ID_FORM'],
			"ID_IBLOCK" => $arParams['ID_IBLOCK'],
            "TITLE" => $arParams['TITLE'],
            "SUB_TITLE" => $arParams['SUB_TITLE'],
            "DATE_ACTIVE" => $arParams['DATE_ACTIVE'],
            "DATE_DISABLE" => $arParams['DATE_DISABLE'],
            "IMAGE_URL" => $arParams['IMAGE_URL']
		);
		return $arParams;
	}

    public function executeComponent() {
        $this->_request = Application::getInstance()->getContext()->getRequest();
        $this->includeComponentTemplate();
    }
}?>