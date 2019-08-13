<?php

namespace CODEMASCHINE\CmAjaxContactForm\Tests\Unit\Domain\Model;

/***************************************************************
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
 * Test case for class \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Jannes Dinse <jdinse@codemaschine.de>
 * @author Sebastian Tobies <stobies@codemaschine.de>
 */
class ContactTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \CODEMASCHINE\CmAjaxContactForm\Domain\Model\Contact();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName() {
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getContactDataReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getContactData()
		);
	}

	/**
	 * @test
	 */
	public function setContactDataForStringSetsContactData() {
		$this->subject->setContactData('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'contactData',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMessageReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getMessage()
		);
	}

	/**
	 * @test
	 */
	public function setMessageForStringSetsMessage() {
		$this->subject->setMessage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'message',
			$this->subject
		);
	}
}
