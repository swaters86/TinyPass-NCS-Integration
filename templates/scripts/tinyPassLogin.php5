/**
 * Author: Steve Waters
 *
 * This script is called from the tinyPassLogin_ovr.pbs template which is 
 * requested via an Ajax script (see header.pbo Macro)
**/

$timeStamp = '12/11/20 11:18:44 AM';

// Write LOGININFO to session file  
$SOSE->WriteSession("DisplayID", "0", "LOGININFO");
$SOSE->WriteSession("ExternalID", "000000", "LOGININFO");
$SOSE->WriteSession("GroupID", "0", "LOGININFO");
$SOSE->WriteSession("LoginName", "000000", "LOGININFO");
$SOSE->WriteSession("TimeStamp", $timeStamp, "LOGININFO");	
$SOSE->WriteSession("SingleSale", "PREMIUM1", "LOGININFO",true);

