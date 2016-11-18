# TinyPass Integration

**Please note:** This integration never went into production, however, it was able to function as a TinyPass paywall solution in the customer's site. After extensive testing, it was proven to work well in this environment. 

This integration uses the TinyPass API, which has been documented here: http://developer.tinypass.com/

## Publicus.ini 

This file contains the configuration settings such as the EXTLOGIN section settings (used by our access control system) and a custom section called TINYPASS. The tinyPassLink.php5 and tinyPassTicket.php5 scripts read off of this section.

## gen_art.pbs

The default article template for this solution. This doesn't have to be copied over.

## gen_art_extlogin.pbs

This is the template used by NEWSCYCLE Digital when the user has exceeded the amount of allowed views. 

## article.pbo 

This is the default article Object File that the PBS article tag in gen_art.pbs is using. This one doesn't have to be copied over, you can use the one you have; However, you should have this code in this Object File. 

    <script type="text/javascript">
    // We're setting the SingleSaleId here so it can be cached with the article.
    singleSaleId = '<%SingleSaleID%>';
    </script>

    <!-- Set Access Variables and Show/Hide Div containers for the TinyPass paywall -->

    <pbs:#sessioninfopostproc_1#>	

## articleExtLogin.pbo 

This is the default article Object File that the PBS article tag in gen_art_extlogin.pbs uses to format content. This one is required, it should contain all the article content that you want to display to visitors when they hit the paywall. Again, it should contain the same JavaScript code and the same PBS SessionInfoPostProc_1 tag as the article.pbo Object File. 

## sessionInfoPostProc1.pbo

This object file is updated and is persistent for each new client, so information isn't cached in this file for other users to see... 

It does the following: 


*   Gets the tinyPassLogin_ovr.pbs template via Ajax which will write PREMIUM1 to the session file for the user.  This only happens when the refreshPage callback function is called from one of the API scripts such as tinyPassLink.php5 and tinyPassTicket.php5
*   If the tinyPassLogin template is retrieved successfully then the page is reloaded, this forces NEWSCYCLE Digital to read the session file again which will then tell the application to use the gen_art.pbs template. 
*   When the document is ready, this object file will check to see if the singleSaleId variable (which is declared in the article.pbo and articleExtLogin.pbo Object Files) has a value or not; Otherwise, it will hide the DIV containers. One of these DIV contains a Object Script call for the tinyPassticket.php5 script and the other container contains markup for displaying the allowed views left count. These containers are #tp-container-1 and #tp-container-1, respectively. 

*   If the singleSaleId variable has a value, then the JS script in this file will:
- Declare a variable for each of the aforementioned containers (which also happens when the script needs to hide these containers)
- Declares a variable for the "allowed views count" (this value is retrieved from the session file and the <%allowedViewsLeft%> variable is declared in the setAccessVariables.js file).
- Declares a variable for the “single sale status” 
- Declares a variable for the #tp-counter container and sets the contents of this container of the value of the **allowedViesLeft** variable.
- Checks to see if the allowedViewsLeft container is greater than 0, if so then it will show the allowed views left container and hide the tinypass ticket button. Otherwise, it will do the opposite of this. 
- Checks to see if the singleSaleStatus varaible is empty, if so then it will hide both of the containers. This part might not be required in this solution... 

* This Object File also calls the tinyPassTicket.php5 script, which is loading on each article request (regardless if it's protected or not...)

## tinyPassLink.php5

This utilizes the TinyPass API library. PLEASE be sure to change the include file paths! or this will definately not work for you. The primary purpose of this script is so a login link can be rendered on a page instead of the TinyPass ticket button. 

## tinyPassTicket.php5 

This utilizes the TinyPass API library. PLEASE be sure to change the include file paths! or this will definately not work for you. There also The primary purpose of this script is to display the TinyPass ticket button. 

## tinyPassLogin.php5 

This script writes information to the visitors session file if they log in through TinyPass. This script is called in the tinyPassLogin_ovr.pbs template which is loaded in the background via an Ajax script (see header.pbo) 

## tinyPassTicket_ovr.pbs 

Contains the PBS Script tag for calling the tinyPassTicket.php5 script. 

## tinyPassLink_ovr.pbs 

Contains the PBS Script tag for calling the tinyPassLink.php5 script. 

## TinyPass.php5

This file contains the main API class for TinyPass. PLEASE be sure to update the include references in this file as well. 

## header.pbo 

This Macro has an Ajax call which retrieves the tinyPassLink_ovr.pbs template (remember it?) and injects it into a DIV tag with a selector ID of #my-account. You can change this selector if you want! You should add this DIV tag to somewhere in the MASTHEAD area for your site, or wherever you think this link should be displayed.  This Macro also contains a script reference for the tinypass.js library script (I would ask TinyPass about this one , this might be a script that interacts with the cookes this API creates). Lastly, this Macro contains a function that searches for “user_ref” in the URL, if it is present then the tinyPassLogin_ovr.pbs template is called again using AJAX. This was added later in the project, but you might be able to remove it. 




