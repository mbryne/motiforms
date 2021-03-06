<?php
/**
 * The file that defines choice test class
 *
 * @link       http://motivast.com
 * @since      0.1.0
 *
 * @package    Motiforms
 * @subpackage Motiforms/tests
 */

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;

use Symfony\Component\Templating\PhpEngine;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\DomCrawler\Crawler;

/**
 * The class provided for test choice fields
 *
 * @link       http://motivast.com
 * @since      0.1.0
 *
 * @package    Motiforms
 * @subpackage Motiforms/tests
 */
class Choice_Test extends WP_UnitTestCase {

	/**
	 * Test rendering collapsed choice type field
	 */
	function test_creating_collapsed_choice_type_field() {

		$factory = mf_get_factory();
		$form = $factory->create();

		$available_choices = array(
			'Red'  => 'red',
			'Green' => 'green',
			'Blue' => 'blue',
		);

		$form->add( 'choice', ChoiceType::class, array(
			'choices' => $available_choices,
		) );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$select = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$red   = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select > option:nth-child(1)' );
		$green = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select > option:nth-child(2)' );
		$blue  = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select > option:nth-child(3)' );

		$this->assertEquals( 'form[choice]', $select->attr( 'name' ) );
		$this->assertEquals( 'form_choice', $select->attr( 'id' ) );

		$this->assertEquals( 'option', $red->nodeName() );
		$this->assertEquals( 'red', $red->attr( 'value' ) );
		$this->assertEquals( 'Red', $red->html() );

		$this->assertEquals( 'option', $green->nodeName() );
		$this->assertEquals( 'green', $green->attr( 'value' ) );
		$this->assertEquals( 'Green', $green->html() );

		$this->assertEquals( 'option', $blue->nodeName() );
		$this->assertEquals( 'blue', $blue->attr( 'value' ) );
		$this->assertEquals( 'Blue', $blue->html() );
	}

	/**
	 * Test rendering collapsed choice type field with enabled multiple option
	 */
	function test_creating_collapsed_choice_type_field_with_enabled_multiple_option() {

		$factory = mf_get_factory();
		$form = $factory->create();

		$available_choices = array(
			'Red'  => 'red',
			'Green' => 'green',
			'Blue' => 'blue',
		);

		$form->add( 'choice', ChoiceType::class, array(
			'choices' => $available_choices,
			'multiple' => true,
		) );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$select   = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$red   = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select > option:nth-child(1)' );
		$green = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select > option:nth-child(2)' );
		$blue  = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select > option:nth-child(3)' );

		$this->assertEquals( 'multiple', $select->attr( 'multiple' ) );

		$this->assertEquals( 'option', $red->nodeName() );
		$this->assertEquals( 'red', $red->attr( 'value' ) );
		$this->assertEquals( 'Red', $red->html() );

		$this->assertEquals( 'option', $green->nodeName() );
		$this->assertEquals( 'green', $green->attr( 'value' ) );
		$this->assertEquals( 'Green', $green->html() );

		$this->assertEquals( 'option', $blue->nodeName() );
		$this->assertEquals( 'blue', $blue->attr( 'value' ) );
		$this->assertEquals( 'Blue', $blue->html() );
	}

	/**
	 * Test rendering expaned choice type field
	 */
	function test_creating_expanded_choice_type_field() {

		$factory = mf_get_factory();
		$form = $factory->create();

		$available_choices = array(
			'Red'  => 'red',
			'Green' => 'green',
			'Blue' => 'blue',
		);

		$form->add( 'choice', ChoiceType::class, array(
			'choices' => $available_choices,
			'expanded' => true,
		) );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$red   = $crawler->filter( 'form > #form > .field > .field__label + .field__input > #form_choice > .field__input__choice__wrapper--radio > .field__input__choice--radio > #form_choice_0' );
		$green = $crawler->filter( 'form > #form > .field > .field__label + .field__input > #form_choice > .field__input__choice__wrapper--radio > .field__input__choice--radio > #form_choice_1' );
		$blue  = $crawler->filter( 'form > #form > .field > .field__label + .field__input > #form_choice > .field__input__choice__wrapper--radio > .field__input__choice--radio > #form_choice_2' );

		$this->assertEquals( 'input', $red->nodeName() );
		$this->assertEquals( 'radio', $red->attr( 'type' ) );
		$this->assertEquals( 'red', $red->attr( 'value' ) );

		$this->assertEquals( 'input', $green->nodeName() );
		$this->assertEquals( 'radio', $green->attr( 'type' ) );
		$this->assertEquals( 'green', $green->attr( 'value' ) );

		$this->assertEquals( 'input', $blue->nodeName() );
		$this->assertEquals( 'radio', $blue->attr( 'type' ) );
		$this->assertEquals( 'blue', $blue->attr( 'value' ) );
	}

	/**
	 * Test rendering expaned choice type field with enabled multiple option
	 */
	function test_creating_expanded_choice_type_field_with_enabled_multiple_option() {

		$factory = mf_get_factory();
		$form = $factory->create();

		$available_choices = array(
			'Red'  => 'red',
			'Green' => 'green',
			'Blue' => 'blue',
		);

		$form->add( 'choice', ChoiceType::class, array(
			'choices' => $available_choices,
			'expanded' => true,
			'multiple' => true,
		) );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$red   = $crawler->filter( 'form > #form > .field > .field__label + .field__input > #form_choice > .field__input__choice__wrapper--checkbox > .field__input__choice--checkbox > #form_choice_0' );
		$green = $crawler->filter( 'form > #form > .field > .field__label + .field__input > #form_choice > .field__input__choice__wrapper--checkbox > .field__input__choice--checkbox > #form_choice_1' );
		$blue  = $crawler->filter( 'form > #form > .field > .field__label + .field__input > #form_choice > .field__input__choice__wrapper--checkbox > .field__input__choice--checkbox > #form_choice_2' );

		$this->assertEquals( 'input', $red->nodeName() );
		$this->assertEquals( 'checkbox', $red->attr( 'type' ) );
		$this->assertEquals( 'red', $red->attr( 'value' ) );

		$this->assertEquals( 'input', $green->nodeName() );
		$this->assertEquals( 'checkbox', $green->attr( 'type' ) );
		$this->assertEquals( 'green', $green->attr( 'value' ) );

		$this->assertEquals( 'input', $blue->nodeName() );
		$this->assertEquals( 'checkbox', $blue->attr( 'type' ) );
		$this->assertEquals( 'blue', $blue->attr( 'value' ) );
	}

	/**
	 * Test rendering country choice type field with set locale
	 */
	function test_creating_country_choice_type_field_with_set_locale() {

		\Locale::setDefault( 'pl' );

		$factory = mf_get_factory();
		$form = $factory->create();

		$form->add( 'countries', CountryType::class );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$countries = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$this->assertEquals( 'select', $countries->nodeName() );
		$this->assertEquals( 255, count( $countries->children() ) );

		$this->assertEquals( 'Polska', $countries->filter( 'option[value="PL"]' )->text() );
	}

	/**
	 * Test rendering language choice type field with set locale
	 */
	function test_creating_language_choice_type_field_with_set_locale() {

		\Locale::setDefault( 'pl' );

		$factory = mf_get_factory();
		$form = $factory->create();

		$form->add( 'languages', LanguageType::class );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$languages = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$this->assertEquals( 'select', $languages->nodeName() );
		$this->assertEquals( 616, count( $languages->children() ) );

		$this->assertEquals( 'angielski', $languages->filter( 'option[value="en"]' )->text() );
	}

	/**
	 * Test rendering locale choice type field with set locale
	 */
	function test_creating_locale_choice_type_field_with_set_locale() {

		\Locale::setDefault( 'pl' );

		$factory = mf_get_factory();
		$form = $factory->create();

		$form->add( 'locales', LocaleType::class );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$locales = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$this->assertEquals( 'select', $locales->nodeName() );
		$this->assertEquals( 564, count( $locales->children() ) );

		$this->assertEquals( 'angielski (Stany Zjednoczone)', $locales->filter( 'option[value="en_US"]' )->text() );
	}

	/**
	 * Test rendering timezone choice type field
	 */
	function test_creating_timezone_choice_type_field() {

		$factory = mf_get_factory();
		$form = $factory->create();

		$form->add( 'timezones', TimezoneType::class );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$timezones = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$this->assertEquals( 'select', $timezones->nodeName() );
		$this->assertEquals( 11, count( $timezones->children() ) );

		$this->assertEquals( 'Warsaw', $timezones->filter( 'option[value="Europe/Warsaw"]' )->text() );
	}

	/**
	 * Test rendering currency choice type field with set locale
	 */
	function test_creating_currency_choice_type_field_with_set_locale() {

		\Locale::setDefault( 'pl' );

		$factory = mf_get_factory();
		$form = $factory->create();

		$form->add( 'currencies', CurrencyType::class );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler();
		$crawler->addHtmlContent( $engine['form']->form( $form_view ) ); // Use addHtmlContent method to force proper encoding.

		$currencies = $crawler->filter( 'form > #form > .field > .field__label + .field__input > select' );

		$this->assertEquals( 'select', $currencies->nodeName() );
		$this->assertEquals( 285, count( $currencies->children() ) );

		$this->assertEquals( 'złoty polski', $currencies->filter( 'option[value="PLN"]' )->text() );
	}
}
