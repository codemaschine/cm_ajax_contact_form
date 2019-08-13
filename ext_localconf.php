<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'CODEMASCHINE.' . $_EXTKEY,
	'Ajaxcontactform',
	array(
		'Contact' => 'new, create',
		
	),
	// non-cacheable actions
	array(
		'Contact' => 'create',
		
	)
);
