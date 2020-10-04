<?php

namespace DimChtz\ClientIP;

/**
 * ClientIP
 *
 * ClientIP provides ways to get the client's IP
 * or the client's external IP (mainly for localhost development environments)
 * and various IP validations
 *
 * @package dimchtz/clientip
 * @link https://github.com/DimChtz/ClientIP
 * @license http://www.opensource.org/licenses/mit-license.html
 * @author Dimitris Chatzis
 * @version 0.1.0
 */

class ClientIP {

	/**
	 * IP Services
	 * @var string
	 */
	private $services;

	public function __construct($services = array()) {

		$this->services = array_merge(array(
			'http://v4.ident.me/',
			'http://checkip.amazonaws.com/',
        	'http://ipecho.net/plain',
        	'http://icanhazip.com/',
        	'http://ifconfig.me/ip',
        	'http://checkip.dyndns.com/',
		), $services);

	}

	/**
	 * Retrieves client's external IP using the registered services
	 * @return string The external IP if found, 0.0.0.0 otherwise
	 */
	public function get_external_ip() {
		
		$ip = '0.0.0.0';

		// Some IP services may stop working or throttle our requests
		foreach ( $this->services as $service ) {

			$ch =  curl_init($service);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
	    		"Accept-Encoding: gzip, deflate",
	    		"Accept-Charset: utf-8;q=0.7,*;q=0.3",
	    		"Accept-Language:en-US;q=0.6,en;q=0.4",
	    		"Connection: keep-alive",
			));

			$result = trim(curl_exec($ch));

			curl_close($ch);

			if ( ClientIP::is_valid_ip($result) ) {
				return $result;
			}

		}

		return $ip;

	}

	/**
	 * Retrieves client's IP
	 * @param bool $localhost_check
	 * @return string The client's IP
	 */
	public function get_ip($localhost_check = true) {

		$ip = '0.0.0.0';
	
		if ( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        	if ( strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0 ) {
            	$ip = trim(explode(",",$_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        	} else {
            	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        	}
    	} else {
        	$ip = $_SERVER['REMOTE_ADDR'];
        }

        // If localhost and localhost check is enabled return the external IP instead
    	if ( in_array($ip, ['127.0.0.1', '::1']) && $localhost_check ) {
        	return $this->get_external_ip();
    	}

    	return $ip;

	}

	/**
	 * Checks if the client's IP is localhost
	 * @return bool true if localhost, false otherwise
	 */
	public function is_localhost() {

		return in_array($this->get_ip(false), ['127.0.0.1', '::1']);

	}

	/**
	 * Checks if the input is a valid IP (ipv4 or ipv6)
	 * @return bool true if IP is valid, false otherwise
	 */
	public static function is_valid_ip($ip) {

		return filter_var($ip, FILTER_VALIDATE_IP) !== false;

	}

	/**
	 * Checks if the input is a valid IPv4
	 * @return bool true if IP is valid, false otherwise
	 */
	public static function is_valid_ipv4($ip) {

		return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;

	}

	/**
	 * Checks if the input is a valid IPv6
	 * @return bool true if IP is valid, false otherwise
	 */
	public static function is_valid_ipv6($ip) {

		return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;

	}

}