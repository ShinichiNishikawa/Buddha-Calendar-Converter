<?php

class SampleTest extends WP_UnitTestCase {

	public $the_post;
	public $loaded;

	public function setUp() {

		parent::setUp();

		$post_date     = '2015-09-21 03:00:45'; // This is Monday.

		$this->the_post = $this->factory->post->create_and_get( array(
			'post_title'    => 'Posted on 21th Sept, 2015',
			'post_date'     => $post_date,
		) );

		require_once ABSPATH . 'wp-admin/includes/translation-install.php';
		$loaded_language = wp_download_language_pack( 'th' );
		$this->loaded = load_default_textdomain( 'th' );

	}
	

	public function test_this_test() {

		$this->assertEquals( 'Posted on 21th Sept, 2015', get_the_title( $this->the_post ) );

	}

	public function test_date_format_none_in_EN() {

		$this->assertEquals( 'September 21, 2558', get_the_date( '', $this->the_post ) );

	}

	public function test_date_format_all_in_EN() {

		$this->assertEquals( 
			'21 Mon 21 Monday 1 st 1 263 39 September 09 Sep 9 30 0 2558 2015 15 am AM 167 3 3 03 03 00 45 000000 UTC 0 +0000 +00:00 UTC 0 2015-09-21T03:00:45+00:00 Mon, 21 Sep 2015 03:00:45 +0000 1442804445', 
			get_the_date( 
				"d D j l N S w z W F m M n t L o Y y a A B g G h H i s u e I O P T Z c r U", 
				$this->the_post 
			) 
		);

	}

	public function test_time_format_all_in_EN() {

		$this->assertEquals( 
			'21 Mon 21 Monday 1 st 1 263 39 September 09 Sep 9 30 0 2558 2015 15 am AM 167 3 3 03 03 00 45 000000 UTC 0 +0000 +00:00 UTC 0 2015-09-21T03:00:45+00:00 Mon, 21 Sep 2015 03:00:45 +0000 1442804445', 
			get_the_time( 
				"d D j l N S w z W F m M n t L o Y y a A B g G h H i s u e I O P T Z c r U", 
				$this->the_post 
			) 
		);

	}

	public function test_escape() {

//		$this->assertEquals( 'I love you.', get_the_date( "\I \l\o\v\e \y\o\u.", $this->the_post ) );

	}


	public function test_date_format_none_in_TH() {

		$GLOBALS['wp_locale'] = new WP_Locale();
		$this->assertEquals( 'กันยายน 21, 2558', get_the_date( '', $this->the_post ) );

	}

	public function test_date_format_all_in_TH() {

		$GLOBALS['wp_locale'] = new WP_Locale();
		$this->assertEquals( 
			'21 จันทร์ 21 วันจันทร์ 1 st 1 263 39 กันยายน 09 ก.ย. 9 30 0 2558 2015 15 am AM 167 3 3 03 03 00 45 000000 UTC 0 +0000 +00:00 UTC 0 2015-09-21T03:00:45+00:00 Mon, 21 Sep 2015 03:00:45 +0000 1442804445', 
			get_the_date( 
				"d D j l N S w z W F m M n t L o Y y a A B g G h H i s u e I O P T Z c r U", 
				$this->the_post 
		) );

	}

	public function test_time_format_all_in_TH() {

		$GLOBALS['wp_locale'] = new WP_Locale();
		$this->assertEquals( 
			'21 จันทร์ 21 วันจันทร์ 1 st 1 263 39 กันยายน 09 ก.ย. 9 30 0 2558 2015 15 am AM 167 3 3 03 03 00 45 000000 UTC 0 +0000 +00:00 UTC 0 2015-09-21T03:00:45+00:00 Mon, 21 Sep 2015 03:00:45 +0000 1442804445', 
			get_the_time( 
				"d D j l N S w z W F m M n t L o Y y a A B g G h H i s u e I O P T Z c r U", 
				$this->the_post 
		) );

	}

	public function test_locale() {

		global $wp_locale, $locale;

		$this->assertTrue( $this->loaded );
		$this->assertEquals( 'en_US', get_locale() );
		$this->assertEquals( 'en_US', $locale );

		add_filter( 'locale', array( $this, 'set_locale_to_th' ) );

		$this->assertEquals( 'th', get_locale() );
		$this->assertEquals( 'en_US', $locale );

	}

	public function set_locale_to_th( $locale ) {
		return 'th';
	}

}

