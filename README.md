emailctid.php - Send notifications when a load average threshold is reached, and include openvz CTIDs  
released under WTFPL - http://www.wtfpl.net/about/  
Emails notifications that look like http://disclosed.info/6

Place emailctid.php anywhere on your server.

Edit emailctid.php with your favorite editor, and modify the two variables under Configuration.

Install in root crontab like:
5 * * * * /path/to/php-cli /path/to/emailctid.php
will run the script every 5 minutes

Sit back and wait for abusers to stagnate your efficiency.
