<?php

include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\policies\\TPPolicy.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\policies\\Policies.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TPRIDHash.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TinyPassGateway.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TPResource.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TPOffer.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TinyPassException.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TPPriceOption.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TPUtils.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\ui\\TPPurchaseRequest.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\ui\\TPHtmlWidget.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TPClientMsgBuilder.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPClientBuilder.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPClientParser.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPCookieParser.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPSecureEncoder.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPOpenEncoder.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPJsonMsgBuilder.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\builder\\TPSecurityUtils.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\token\\TPAccessTokenStore.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\token\\TPMeterStore.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\token\\TPMeter.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\token\\TPAccessToken.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\token\\TPAccessTokenList.php';
include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\token\\TPTokenData.php';

class TinyPass {

	public static $API_ENDPOINT_PROD = "https://api.tinypass.com";
	public static $API_ENDPOINT_SANDBOX = "https://sandbox.tinypass.com";
	public static $API_ENDPOINT_DEV = "";

	public static $AID = "";
	public static $PRIVATE_KEY = "";
	public static $SANDBOX = false;

	public static $CONNECTION_TIMEOUT = 5000;
	public static $READ_TIMEOUT = 10000;

	public static function config($aid = null, $privateKey = null, $sandbox = null) {
		if($aid)
			return new TPConfig($aid, $privateKey, $sandbox);
		return new TPConfig(self::$AID, self::$PRIVATE_KEY, self::$SANDBOX);
	}

	public static function fetchAccessDetails($params, $page = 0, $pagesize = 500) {
		return TinyPassGateway::fetchAccessDetails($params);
	}

	public static function fetchAccessDetail($params) {
		return TinyPassGateway::fetchAccessDetail($params);
	}

	public static function revokeAccess($params) {
		return TinyPassGateway::revokeAccess($params);
	}

	public static function cancelSubscription($params) {
		return TinyPassGateway::cancelSubscription($params);
	}

	public static function fetchSubscriptionDetails($params) {
		return TinyPassGateway::fetchSubscriptionDetails($params);
	}

}

class TPConfig {

	public static $VERSION = "2.0.7";
	public static $MSG_VERSION = "2.0p";

	public static $CONTEXT = "/v2";
	public static $REST_CONTEXT = "/r2";

	public static $COOKIE_SUFFIX = "_TOKEN";
	public static $COOKIE_PREFIX = "__TP_";

	public $AID;
	public $PRIVATE_KEY;
	public $SANDBOX;

	public function __construct($aid, $privateKey, $sandbox) {
		$this->AID = $aid;
		$this->PRIVATE_KEY = $privateKey;
		$this->SANDBOX = $sandbox;
	}

	public function getEndPoint() {
		if(TinyPass::$API_ENDPOINT_DEV != null && strlen(TinyPass::$API_ENDPOINT_DEV) > 0) {
			return TinyPass::$API_ENDPOINT_DEV;
		} else if(TinyPass::$SANDBOX) {
			return TinyPass::$API_ENDPOINT_SANDBOX;
		} else {
			return TinyPass::$API_ENDPOINT_PROD;
		}
	}

	public static function getTokenCookieName($aid) {
		return self::$COOKIE_PREFIX . $aid . self::$COOKIE_SUFFIX;
	}

	public static function getAppPrefix($aid) {
		return "__TP_" . $aid;
	}

}

?>