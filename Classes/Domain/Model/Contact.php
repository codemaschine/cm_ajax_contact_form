<?php
namespace CODEMASCHINE\CmAjaxContactForm\Domain\Model;


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
 * Contact
 */
class Contact extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name = '';

	/**
	 * contactData
	 *
	 * @var string
	 */
	protected $contactData = '';

	/**
	 * email
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * phone
	 *
	 * @var string
	 */
	protected $phone;

	/**
	 * message
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $message = '';

	/**
	 * crdate
	 *
	 * @var integer
	 */
	protected $crdate;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the contactData
	 *
	 * @return string $contactData
	 */
	public function getContactData() {
		return $this->contactData;
	}

	/**
	 * Sets the contactData
	 *
	 * @param string $contactData
	 * @return void
	 */
	public function setContactData($contactData) {
		$this->contactData = $contactData;
	}

	/**
	 * Returns the message
	 *
	 * @return string $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets the message
	 *
	 * @param string $message
	 * @return void
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 *
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 *
	 * @param string $phone
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}

  /**
   *
   * @return integer
   */
  public function getCrdate() {
    return $this->crdate;
  }

  /**
   *
   * @param integer $crdate
   */
  public function setCrdate($crdate) {
    $this->crdate = $crdate;
    return $this;
  }

}
