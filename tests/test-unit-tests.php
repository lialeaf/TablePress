<?php

/**
 * Tests to test that the testing framework is working properly.
 */
class TablePress_Test_Unit_Tests extends TablePress_TestCase {

	/**
	 * Run a simple test to ensure that the tests are running.
	 */
	public function test_true_is_true() {
		$this->assertTrue( true );
	}

	/**
	 * If these tests are being run on Travis CI, verify that the version of
	 * WordPress installed is the version that we requested.
	 * This test requires PHP 5.3, as PHP 5.2 in Travis CI does not support HTTPS.
	 *
	 * @requires PHP 5.3
	 */
	public function test_wp_version() {
		if ( ! getenv( 'TRAVIS' ) ) {
			$this->markTestSkipped( 'Test skipped since Travis CI was not detected.' );
		}

		$requested_version = getenv( 'WP_VERSION' ) . '-src';
		// Strip .0 from version string, as that's only used in the SVN/git tag, but not in the code.
		$requested_version = str_replace( '.0', '', $requested_version );

		// The "master" version requires special handling.
		if ( 'master-src' === $requested_version ) {
			$file = file_get_contents( 'https://develop.svn.wordpress.org/trunk/src/wp-includes/version.php' );
			preg_match( '#\$wp_version = \'([^\']+)\';#', $file, $matches );
			$requested_version = $matches[1];
		}

		$this->assertEquals( get_bloginfo( 'version' ), $requested_version );
	}

	/**
	 * Ensure that the plugin has been installed and activated.
	 */
	public function test_plugin_is_activated() {
		$this->assertTrue( is_plugin_active( 'tablepress/tablepress.php' ) );
	}

}
