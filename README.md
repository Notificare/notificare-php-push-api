# Notificare PHP Server-Side Library

Use this PHP Library to implement the Notificare Push API public resources in your own applications.

## Prerequisites

- PHP 5.3
- cURL + SSL

You can check by running diagnostics from the command line:

	php diag.php
	
On some installations (e.g., Windows), you need to point to a CA certificate bundle 


## Installation

- Copy the contents of this folder to the WWW document root of your webserver
- Grab your ApplicationKey and MasterSecret from the Notificare Dashboard
- Put them in notificare/notificare.php file
- Optionally, set your own CA certificate bundle path (in the same file)
- Surf to http://<webserver>/examples.php

## More help

For documentation please refer to: https://notificare.atlassian.net/wiki/display/notificare/Home

For support please use: https://notificare.zendesk.com
