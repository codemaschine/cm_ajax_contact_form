<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Ajaxcontactform',
	'Ajax Contact Form'
);

if (TYPO3_MODE === 'BE') {
	

	// Neues Modul unter Modul "Web" eintragen
	if (!in_array('managers', $TBE_MODULES))
	  $TBE_MODULES = array_slice($TBE_MODULES, 0, 1) + array('managers' => '') + array_slice($TBE_MODULES, 1);
	// http://docs.typo3.org/TYPO3/InsideTypo3Reference/CoreArchitecture/BackendModules/BackendModuleApi/Index.html

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CODEMASCHINE.' . $_EXTKEY,
		'managers',	 // Make module a submodule of 'tools'
		'contactmanager',	// Submodule key
		'',						// Position
		array(
			'Contact' => 'list, show, new, create, edit, update, delete',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_contactmanager.xlf',
		)
	);

}



$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginNames = array('ajaxcontactform');

foreach ($pluginNames as $pluginName) {
	$pluginSignature = strtolower($extensionName) . '_'.$pluginName;

	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive';
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/'.$pluginName.'.xml');
}
//---


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Ajax Contact Form');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cmajaxcontactform_domain_model_contact', 'EXT:cm_ajax_contact_form/Resources/Private/Language/locallang_csh_tx_cmajaxcontactform_domain_model_contact.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cmajaxcontactform_domain_model_contact');
