<?php
/**
 * The file that defines buttons test class
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    Motiforms
 * @subpackage Motiforms/tests
 */

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use Symfony\Component\Templating\PhpEngine;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\DomCrawler\Crawler;

/**
 * The class provided for test buttons fields
 *
 * @link       http://motivast.com
 * @since      1.0.0
 *
 * @package    Motiforms
 * @subpackage Motiforms/tests
 */
class Buttons_Test extends WP_UnitTestCase {

	/**
	 * Test rendering button type field
	 */
	function test_rendering_button_type_field() {

		$factory = mf_get_factory();
		$form = $factory->create();

		$form->add( 'button', ButtonType::class );

		$form_view = $form->createView();

		$engine = mf_get_engine();

		$crawler = new Crawler( $engine['form']->form( $form_view ) );

		$button = $crawler->filter( 'form > #form > div > #form_button' );

		$this->assertEquals( 'button', $button->nodeName() );
		$this->assertEquals( 'button', $button->attr( 'type' ) );
		$this->assertEquals( 'form[button]', $button->attr( 'name' ) );
	}
}
