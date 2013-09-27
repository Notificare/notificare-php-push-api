<?php
/**
 * Diagnostics script for testing requirements and connectivity
 * 
 * Run this script from the command line like this:
 * 
 * 	php diag.php
 * 
 * @author Joris Verbogt <joris@notifica.re>
 */

/**
 * Check if curl is installed
 * @return boolean
 */
function checkCURL() {
	if (function_exists("curl_version")) {
		$version = curl_version();
		if ($version["features"] & CURL_VERSION_SSL) {
			echo "cURL version " . $version["version"] . " with SSL " . $version["ssl_version"] . " enabled\n\n";
			return true;
		} else {
			echo "cURL version " . $version["version"] . " installed, but SSL not enabled\n\n";
		}
	} else {
		echo "cURL not installed or enabled\n\n";
	}
	return false;
}

/**
 * Check if we can get a status report from Notificare Push API
 * @return boolean
 */
function checkConnectivity() {
	$stream = curl_init();
	if ($stream) {
		curl_setopt($stream, CURLOPT_URL, "https://push.notifica.re/status");
		curl_setopt($stream, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($stream, CURLOPT_HEADER, 0);
		curl_setopt($stream, CURLOPT_VERBOSE, 1);
		curl_setopt($stream, CURLOPT_HTTPGET, 1);
		/*
		 * Uncomment the following if you get SSL self-signed certificate errors
		 */
		//curl_setopt($stream, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem");
		curl_setopt($stream, CURLOPT_USERAGENT, "PHP Diagnostics Test 1.0");
		$result = curl_exec($stream);
		$error = curl_error($stream);
		$info = curl_getinfo($stream, CURLINFO_CONTENT_TYPE);
		$statuscode = curl_getinfo($stream, CURLINFO_HTTP_CODE);
		curl_close($stream);
		if ($error) {
			echo "\nGot an error: " . $error . "\n"; 
		} else {
			echo "\nGot result: " . $statuscode . "\n" . $info . "\n" . $result . "\n";
			return true;
		}
	} else {
		echo "Unable to open connection\n";
	}
	return false;
}

echo "\nRunning diagnostics...\n\n";

if (checkCURL()) {
	checkConnectivity();
}
