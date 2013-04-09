<?php

//emailctid.php - Send notifications when a load average threshold is reached, and include openvz CTIDs
//Damian Harouff - 2013-04-08
//released under WTFPL - http://www.wtfpl.net/about/

//install in root crontab like:
//5 * * * * /path/to/php-cli /path/to/emailctid.php
//will run the script every 5 minutes

//=========================================================
//Configuration:

$maxLA = 10;			//send notifications when 1 minute load average is over this value

$mailto = 'your@address.here'; 	//put your email address here. Multiple users can be specified comma-delimited 
				//such as bob@website.com,gerald@things.net,bill@place.org

//=========================================================

$load = sys_getloadavg();
$hostname = gethostname();

if ($load[0] > $maxLA) {

	$poundOutput = shell_exec("top -b -n 1|sed -e '1,6d'|perl -pe 's/[ ]+/#/g;s/^[#]+//g;s/[#]+$//g'|head -11");

	$perLine = explode("\n", $poundOutput);

	for ($counter = 1; $counter <= 11; $counter++) {

		$tempdata = explode("#", $perLine[$counter]);
		$pids[] = $tempdata[0];

	}

	$ctids = implode(" ", $pids);
	$vzpid = shell_exec("vzpid " . $ctids);
	$topDisplay = strtr($poundOutput, "#", chr(9));

	$msg .= "Load averages: " . $load[0] . " " . $load[1] . " " . $load[2] . PHP_EOL;
	$msg .= PHP_EOL;

	$msg .= "Top CPU processes by load with their associated CTID: ". PHP_EOL.PHP_EOL;

	$msg .= $vzpid . PHP_EOL;
	
	$msg .= "Output from top: ".PHP_EOL.PHP_EOL;
	$msg .= $topDisplay;
	
	mail($mailto, $hostname . " experiencing high load", $msg);

}

?>
