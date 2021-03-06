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
class Tx_Fluid_Tests_Unit_ViewHelpers_Format_CurrencyViewHelperTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @test
	 */
	public function viewHelperRoundsFloatCorrectly() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(123.456));
		$actualResult = $viewHelper->render();
		$this->assertEquals('123,46', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRendersCurrencySign() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(123));
		$actualResult = $viewHelper->render('foo');
		$this->assertEquals('123,00 foo', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRendersPrependedCurrencySign() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(123));
		$actualResult = $viewHelper->render('foo', ',', '.', TRUE);
		$this->assertEquals('foo 123,00', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRespectsCurrencySeparator() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(123));
		$actualResult = $viewHelper->render('foo', ',', '.', TRUE, FALSE);
		$this->assertEquals('foo123,00', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRespectsDecimalSeparator() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(12345));
		$actualResult = $viewHelper->render('', '|');
		$this->assertEquals('12.345|00', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRespectsThousandsSeparator() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(12345));
		$actualResult = $viewHelper->render('', ',', '|');
		$this->assertEquals('12|345,00', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRendersNullValues() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(NULL));
		$actualResult = $viewHelper->render();
		$this->assertEquals('0,00', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperRendersNegativeAmounts() {
		$viewHelper = $this->getMock('Tx_Fluid_ViewHelpers_Format_CurrencyViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(-123.456));
		$actualResult = $viewHelper->render();
		$this->assertEquals('-123,46', $actualResult);
	}
}

?>
