<?php

/*                                                                        *
 * This script is backported from the FLOW3 package "TYPO3.Fluid".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 */
class Tx_Fluid_Tests_Unit_ViewHelpers_Format_HtmlentitiesViewHelperTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Fluid_ViewHelpers_Format_HtmlentitiesViewHelper
	 */
	protected $viewHelper;

	public function setUp() {
		$this->viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_HtmlentitiesViewHelper', array('renderChildren'));
	}

	/**
	 * @test
	 */
	public function viewHelperDeactivatesEscapingInterceptor() {
		$this->assertFalse($this->viewHelper->isEscapingInterceptorEnabled());
	}

	/**
	 * @test
	 */
	public function renderUsesValueAsSourceIfSpecified() {
		$this->viewHelper->expects($this->never())->method('renderChildren');
		$actualResult = $this->viewHelper->render('Some string');
		$this->assertEquals('Some string', $actualResult);
	}

	/**
	 * @test
	 */
	public function renderUsesChildnodesAsSourceIfSpecified() {
		$this->viewHelper->expects($this->atLeastOnce())->method('renderChildren')->will($this->returnValue('Some string'));
		$actualResult = $this->viewHelper->render();
		$this->assertEquals('Some string', $actualResult);
	}

	/**
	 * @test
	 */
	public function renderDoesNotModifyValueIfItDoesNotContainSpecialCharacters() {
		$source = 'This is a sample text without special characters.';
		$actualResult = $this->viewHelper->render($source);
		$this->assertSame($source, $actualResult);
	}

	/**
	 * @test
	 */
	public function renderDecodesSimpleString() {
		$source = 'Some special characters: &©"\'';
		$expectedResult = 'Some special characters: &amp;&copy;&quot;\'';
		$actualResult = $this->viewHelper->render($source);
		$this->assertEquals($expectedResult, $actualResult);
	}

	/**
	 * @test
	 */
	public function renderRespectsKeepQuoteArgument() {
		$source = 'Some special characters: &©"\'';
		$expectedResult = 'Some special characters: &amp;&copy;"\'';
		$actualResult = $this->viewHelper->render($source, TRUE);
		$this->assertEquals($expectedResult, $actualResult);
	}

	/**
	 * @test
	 */
	public function renderRespectsEncodingArgument() {
		$source = utf8_decode('Some special characters: &©"\'');
		$expectedResult = 'Some special characters: &amp;&copy;&quot;\'';
		$actualResult = $this->viewHelper->render($source, FALSE, 'ISO-8859-1');
		$this->assertEquals($expectedResult, $actualResult);
	}

	/**
	 * @test
	 */
	public function renderConvertsAlreadyConvertedEntitiesByDefault() {
		$source = 'already &quot;encoded&quot;';
		$expectedResult = 'already &amp;quot;encoded&amp;quot;';
		$actualResult = $this->viewHelper->render($source);
		$this->assertEquals($expectedResult, $actualResult);
	}

	/**
	 * @test
	 */
	public function renderDoesNotConvertAlreadyConvertedEntitiesIfDoubleQuoteIsFalse() {
		$source = 'already &quot;encoded&quot;';
		$expectedResult = 'already &quot;encoded&quot;';
		$actualResult = $this->viewHelper->render($source, FALSE, 'UTF-8', FALSE);
		$this->assertEquals($expectedResult, $actualResult);
	}

	/**
	 * @test
	 */
	public function renderReturnsUnmodifiedSourceIfItIsNoString() {
		$source = new stdClass();
		$actualResult = $this->viewHelper->render($source);
		$this->assertSame($source, $actualResult);
	}
}
?>
