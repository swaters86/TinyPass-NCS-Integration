/**
  This script declares several variables which are usd in the TinyPass integration
  It could probably cleaned up, but you will have to figure out what you can remove :) 
*/

var currentUserlevel;
var extLogInSetting;

// Get's story information 
var currentStorySiteCode = SOSE.GetVar("@StorySite");

// var currentStoryDate = SOSE.GetVar("@StoryDate");
var currentStoryDate = '20131218';
var currentStoryCategory = SOSE.GetVar("@StoryCategory");
var currentStoryId = SOSE.GetVar("@StoryId"); 

currentUserlevel = SOSE.ReadSession("AccessItem", "Anonymous", "LOGININFO");

/* 
 SOSE.Echo(currentUserlevel);
*/

SOSE.SetVar("currentUserlevel", currentUserlevel);

SOSE.SetVar("viewedStories", SOSE.ReadSession("ALL", "", "LOGININFO_VIEWEDSTORIES"));

// Builds the below string that is stored in the session file for the user
// CP;20131218;TEST;131219895
var currentStoryViewString = currentStorySiteCode + ";" + currentStoryDate + ";" + currentStoryCategory + ";" + currentStoryId;

SOSE.SetVar("currentStoryViewString",currentStoryViewString);

// Sets a variable so the number of times a story has been viewed can be displayed 
SOSE.SetVar("currentStoryViewCount", SOSE.ReadSession(currentStoryViewString, "", "LOGININFO_VIEWEDSTORIES")); 

extLogInSetting = SOSE.ReadConfig("StoryAllowLimitedAccess","empty", "EXTLOGIN");

SOSE.SetVar("limitedAccessDefaults", extLogInSetting);

// This does the math fro display the number of views/clicks that are left for the user
extLogInSetting = extLogInSetting.substr(extLogInSetting.indexOf(currentUserlevel,0)+currentUserlevel.length+1,2);

SOSE.SetVar("totalAllowedView", extLogInSetting);

SOSE.SetVar("allowedViewsLeft", extLogInSetting-SOSE.ReadSession("NoOfStoriesViewed", "", "LOGININFO"));

SOSE.SetVar("singleSaleStatus", SOSE.ReadSession("SingleSale", "", "LOGININFO"));

/*
 SOSE.Echo(SOSE.GetVar("limitedAccessDefaults"));
*/