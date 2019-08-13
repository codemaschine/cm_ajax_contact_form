<?php
namespace CODEMASCHINE\CmAjaxContactForm\Domain\Validator;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
 *  (c) 2011 Bastian Waidelich <bastian@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * 
 */
class ContactValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {
	
	private $hasErrors = false;
	

	/**
	 * Checks whether the given blog is valid
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @return boolean TRUE if blog could be validated, otherwise FALSE
	 */
	protected function isValid($contact) {
		//$contact = new \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact();
		//\TYPO3\CMS\Core\Utility\GeneralUtility::devLog("Course validation", 'jdtest');
		
		
		if (!$contact->getPhone() && !$contact->getEmail())
			$this->addError('Telefon oder E-Mail muss augefüllt werden', 1397934940);
		
		
		return !$this->hasErrors;
	}
	
	//---
	
	protected function addError($message, $code, array $arguments = array(), $title = '') {
		$this->hasErrors = true;
		parent::addError($message, $code, $arguments, $title);
	}
	
	protected function addPropertyError($property, $message, $code, array $arguments = array(), $title = '') {
		$this->addError("<span class=\"property\">$property</span> $message", $code, $arguments, $title);
	}
}
?>