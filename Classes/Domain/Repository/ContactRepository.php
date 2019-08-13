<?php
namespace CODEMASCHINE\CmAjaxContactForm\Domain\Repository;


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
 * The repository for Contacts
 */
class ContactRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  protected $defaultOrderings = array(
      'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
  );


  // Example for repository wide settings
  public function initializeObject() {

    //$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
    // go for $defaultQuerySettings = $this->createQuery()->getQuerySettings(); if you want to make use of the TS persistence.storagePid with defaultQuerySettings(), see #51529 for details
    $querySettings = $this->createQuery()->getQuerySettings();

    // don't add the pid constraint
    $querySettings->setRespectStoragePage(FALSE);

    //$querySettings->setIgnoreEnableFields(TRUE);
    // define single fields to be ignored
    //$querySettings->setEnableFieldsToBeIgnored(array('starttime','endtime'));

    $this->setDefaultQuerySettings($querySettings);
  }


}
