<?php
namespace CODEMASCHINE\CmAjaxContactForm\Controller;


use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014-2019 Jannes Dinse <jdinse@codemaschine.de>, CODE MASCHINE GmbH
 *                Sebastian Tobies <stobies@codemaschine.de>, CODE MASCHINE GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * ContactController
 */
class ContactController extends \TYPO3\CmAjax\Controller\ApplicationController {
	/*
	 * remove Flash-Message on error
	 */
	protected function getErrorFlashMessage() {
		return false;
	}

	/*
	 * Damit das PropertyMapping bei POST-Argumenten auch erlaubt ist.
	 */
	protected function initializeCreateAction() {
		//\TYPO3\CMS\Core\Utility\GeneralUtility::devLog('alle Properties erlauben', 'jdtest');
		$pmConfiguration = $this->arguments['contact']->getPropertyMappingConfiguration();
		$pmConfiguration->allowAllProperties();
		$pmConfiguration
		->setTypeConverterOption(
				'TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
				\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
				TRUE
		);
	}



	/**
	 * contactRepository
	 *
	 * @var \CODEMASCHINE\CmAjaxContactForm\Domain\Repository\ContactRepository
	 * @inject
	 */
	protected $contactRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$lang = "en";
		if (TYPO3_MODE === 'FE') {
        if (isset($GLOBALS['TSFE']->config['config']['language'])) {
            $lang = $GLOBALS['TSFE']->config['config']['language'];
        }
    } elseif (strlen($GLOBALS['BE_USER']->uc['lang']) > 0) {
        $lang = $GLOBALS['BE_USER']->uc['lang'];
    }
		$contacts = $this->contactRepository->findAll();
		$this->view->assign('contacts', $contacts);
		$this->view->assign('lang', $lang);
	}

	/**
	 * action show
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @return void
	 */
	public function showAction(\CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact) {
		$this->view->assign('contact', $contact);
	}

	/**
	 * action new
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @ignorevalidation $contact
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function newAction(\CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact = NULL) {
		$this->view->assign('contact', $contact);
		$this->view->assign('ownPhone', $this->settings['ownPhone']);
		$this->view->assign('ownEmail', $this->settings['ownEmail']);
		$this->view->assign('textareaAutoGrow', $this->settings['textareaAutoGrow']);
		$this->view->assign('textareaRows', $this->settings['textareaRows']);
		$this->view->assign('textareaResizeable', $this->settings['textareaResizeable']);
		$this->view->assign('phoneActivated', $this->settings['phoneActivated']);
		$this->view->assign('reCAPTCHA_site_key', $this->settings['reCAPTCHA_site_key']);
	}

	/**
	 * action create
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @param string $token Google reCaptcha Token
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function createAction(\CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact, $token) {
	  
	  if ($this->settings['reCAPTCHA_secret_key']) {   // Using Google Recaptcha V3?
  	  // call curl to POST request
  	  $ch = curl_init();
  	  curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
  	  curl_setopt($ch, CURLOPT_POST, 1);
  	  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $this->settings['reCAPTCHA_secret_key'], 'response' => $token)));
  	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	  $response = curl_exec($ch);
  	  curl_close($ch);
  	  $arrResponse = json_decode($response, true);
  	  
  	  // verify the response
  	  if($arrResponse["success"] && $arrResponse["action"] == "submit" && $arrResponse["score"] >= 0.5) {
  	    GeneralUtility::devLog('Google Recaptcha: OK!', 'cm_ajax_contact_form');
  	    // valid submission
  	    // go ahead and do necessary stuff
  	  } else {
            GeneralUtility::devLog('Error: '.var_export($response, true), 'cm_ajax_contact_form');
  	    $this->throwStatus(400, 'error', "Die Kontaktanfrage konnte leider nicht verschickt werden: Der SPAM-Schutz hat ihre Anfrage verweigert. Bitte verwenden Sie direkt per Telefon an uns. Vielen Dank.");
  	    return;
  	    // spam submission
  	  }
	  }
	  
	  
	  $this->contactRepository->add($contact);
		$to = 'jdinse@codemaschine.de';
		if ($this->settings['notifyEmail'])
		  $to = $this->settings['notifyEmail'];

		$subject = "[".$_SERVER['SERVER_NAME']."] ".\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:cm_ajax_contact_form/Resources/Private/Language/locallang_db.xlf:tx_cmajaxcontactform_domain_model_contact.contactRequest');

		if ($this->settings['notifyEmailSubject'])
		  $subject = $this->settings['notifyEmailSubject'];

		  if ($this->settings['from'])
		    $from = $this->settings['from'];
		  else
		    $from = $contact->getEmail() ? $contact->getEmail() : 'noreply@'.$_SERVER['SERVER_NAME'];

		mb_language('en');

		if (!mail($to, $subject, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "
Name: {$contact->getName()}
E-Mail: {$contact->getEmail()}
Telefon: {$contact->getPhone()}

Nachricht:
{$contact->getMessage()}
"), "From: $from\nContent-Type: text/plain;charset=iso-8859-1", "-f$from -r".$from)) {

          if (!$this->isAjax()) {
            $this->addFlashMessage('Die Kontaktanfrage konnte leider nicht verschickt werden. Bitte verwenden Sie direkt per Telefon an uns. Vielen Dank.');
            return $this->redirect('new');
          }
          else
            $this->view->assign('messageTitle', 'Ein Fehler ist aufgetreten');
            $this->view->assign('message', "Die Kontaktanfrage konnte leider nicht verschickt werden. Bitte verwenden Sie direkt per Telefon an uns. Vielen Dank.");
            $this->throwStatus(500, 'error', "Die Kontaktanfrage konnte leider nicht verschickt werden. Bitte verwenden Sie direkt per Telefon an uns. Vielen Dank.".var_export(error_get_last(), true));
            return;
        }


		if (!$this->isAjax())
			$this->redirect('list');
	}

	protected function errorAction(){
	  if ($this->isXhr()) {
	    $this->view->assign('contact',$this->request->getArgument('contact'));
	    $this->throwStatus(400);
	    return $this->view->render('error');
	  }
	  else {
	    parent::errorAction();
	  }
	}


	/**
	 * action edit
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @ignorevalidation $contact
	 * @return void
	 */
	public function editAction(\CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact) {
		$this->view->assign('contact', $contact);
	}

	/**
	 * action update
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @return void
	 */
	public function updateAction(\CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->contactRepository->update($contact);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact
	 * @return void
	 */
	public function deleteAction(\CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact $contact) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->contactRepository->remove($contact);
		$this->redirect('list');
	}

}
