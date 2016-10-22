<?php

/**
 * SkinTemplate class for Cip skin
 * @ingroup Skins
 */
class SkinCip extends SkinTemplate {
	public $skinname = 'cip';
	public $stylename = 'Cip';
	public $template = 'CipTemplate';

	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param OutputPage $out Object to initialize
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$out->addModules( array( 'skins.cip.js' ) );
	}

	/**
	 * Loads skin and user CSS files.
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$styles = array( 'skins.cip.styles' );
		$out->addModuleStyles( $styles );
		$out->addHeadItem('scale', '<meta name="viewport" content="width=device-width, initial-scale=1">');
		$out->addHeadItem('fonts', '<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">');
	}

}
