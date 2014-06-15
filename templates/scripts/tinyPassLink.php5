/**
 * Author: Steve Waters
 * 
 * Displays the TinyPass login link. It will display a message when the visitor is logged in aka has access. 
 *
 * An Ajax call in the defaultTop.pbo Macro sends the return URL this script.
 * Reads several settings from the Publicus.ini file.
 *
 * You can use the below fopen function to write a DB log file to a site's assets folder:
 *
 	$fp = fopen('\\\\sxatl.loc\\sx4\\assets\\[cluster code]\\debuglogs\\tinypass_[test name]txt', 'w');
	fwrite($fp, "add text here or just add . $variblename...");
	fclose($fp);
 *
**/

include '\\\\sxatl.loc\\sx4\\sites\\[cluster code]\\[environment]\\GlobalPaths\\Templates\\scripts\\tinyPassLib\\TinyPass.php';

// Get TinyPass credentials for SandBox mode testing 
$TinyPassSandboxMode = $SOSE->ReadConfig("SandBoxMode", "", "TINYPASS");
 
$TinyPassSandboxMode = strtolower($TinyPassSandboxMode); 

$TinyPassSandBoxAID = $SOSE->ReadConfig("SandBoxAID", "", "TINYPASS");

$TinyPassSandBoxPrivateKey = $SOSE->ReadConfig("SandBoxPrivateKey", "", "TINYPASS");

//Get TinyPass credentials for production 
$TinyPassLiveAID = $SOSE->ReadConfig("LiveAID", "", "TINYPASS");

$TinyPassLivePrivateKey = $SOSE->ReadConfig("LivePrivateKey", "", "TINYPASS");

$TinyPassRID = $SOSE->ReadConfig("RID", "", "TINYPASS");

// Set SandBox mode value to the value that is in the Publcius.ini file
TinyPass::$SANDBOX = $TinyPassSandboxMode;

// Check to see if the SandBox mode value is true, otherwise, use the production site credentials 
if ($TinyPassSandboxMode == "true") {
	TinyPass::$AID = $TinyPassSandBoxAID;
	TinyPass::$PRIVATE_KEY = $TinyPassSandBoxPrivateKey ;
} else {
  TinyPass::$AID = $TinyPassLiveAID;
	TinyPass::$PRIVATE_KEY = $TinyPassLivePrivateKey ;
}

// Set the RID value to the value that is in the Publicus.ini file
$rid = $TinyPassRID;  


// Access Token information 
$store = new TPAccessTokenStore();

// Check to see if the Sandbox mode value is true, otherwise, use the TinyPass Applicattion ID for the live in the GetCookie function. 
if ($TinyPassSandboxMode == "true") {
	$store->loadTokensFromCookie($SOSE->GETCOOKIE('__TP_' . $TinyPassSandBoxAID . '_TOKEN'));
} else {
	$store->loadTokensFromCookie($SOSE->GETCOOKIE('__TP_' . $TinyPassLiveAID . '_TOKEN'));
}

// Get access token from TinyPass. 
$token = $store->getAccessToken($rid);

if($token->isAccessGranted()) {
		
	$SOSE->Echo("<strong style='color:#009752'>You're Logged In!</strong>");

} else {
	
	// Set the resource information
  $resource = new TPResource($rid, "Site wide premium content access");

	/*
	1 Week: $2
	1 Month (reoccurring): $3.75
	1 Year: $49
	*/
	
  $po1 = new TPPriceOption("2.00", "1 week");
  $po2 = new TPPriceOption("[3.75 | monthly | *]");
  $po3 = new TPPriceOption("49.00","1 year");
  
  $offer = new TPOffer($resource, array($po1, $po2, $po3));
  	  
  $request = new TPPurchaseRequest($offer);

	$redirectURL = $SOSE->GetVar("returnURL");

 	$linkHTML = $request->setCallback("refreshPage")->generateLink($redirectURL);
 	
  $SOSE->Echo("<a href='". $linkHTML . "' title=''>Login to Access Content</a>");
			
}





