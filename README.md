ticket-network
==============

TicketNetwork Factory Classes

This set of classes is used to access various SOAP WebService calls
for TicketNetwork http://ticketnetwork.com.

You'll need to have a account at TicketNetwork before you can access
the functions. During testing you'll only be able to access the events for 'Wicked'.
The tnsample.php and genericLib.php are code examples from the TicketNetwork supplied kit. 
They are not needed by this library of classes. The TN kit also includes the tnwsConstants.php. 
This library includes a slightly modified version of tnwsConstants.php so be careful not to 
overwrite it. I have future plans to do away with it but for now I use the constants
to initialize certain parameters.

Also during testing you won't be able to use the method GetEventPerformers since it
returns zero results.

The following constants in tnwsConstants should be modified to reflect the TicketNetwork 
ID's supplied to you after sign up.
DEFINE('WEB_CONF_ID', 12345);
DEFINE('BROKER_ID', 1234);
DEFINE('SITE_ID', 0);

They are used as defaults in the library. You can also override them by passing the 
appropriate values to the factory constructor or factory->config().

See example.php for various ways to use the classes and methods. I believe all the methods
in the tnsample are included but if I missed any let me know and I'll add it to the parse method
for the appropriate class.

# Section 1 - Description
## 1.1 - Purpose
 
 
## 1.2 - Usage and Scope


## 1.3 - Definitions, Acronyms and Abbreviations
Term | Description
---- | -----------


## 1.4 - References


***  
***    
# Section 2 - NameHere  
## 2.1 - Purpose
  
***  
#### 2.2.1 - 
##### 2.2.1.1 - Purpose

##### 2.2.1.2 - Usage and Scope
File | Location | Description
-----| -------- | -----------

##### 2.2.1.3 - Constraints
##### 2.2.1.4 - Deployment
##### 2.2.1.5 - Issues and Risks
 
