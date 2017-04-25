<?php

$xml = simplexml_load_file("config.xml");

$featureCount = count($xml->feature);

$suiteCount = 20;
$minSuiteLength = 3;
$maxSuiteLength = 20;

$debug_log = "";


for ($s = 0; $s < $suiteCount; $s++) {

	echo "<table cellpadding=3 cellspacing=1 border=1>";
	echo "<tr><td colspan=2 bgcolor=#ddd><p><strong>Suite " . $s . "</strong></tr>";

	$currentFeature = -1;
	
	$testsInSuite = rand($minSuiteLength, $maxSuiteLength);
	writeLog("Tests in Suite: " . $testsInSuite);

	for ($t = 0; $t < $testsInSuite; $t++) {

		$selectedFeature = 0;
		$selectedOption = 0;
		$selectedFeatureName = "";
		$selectedOptionName = "";
	
		// Select Feature
		if ($currentFeature == -1) {
			writeLog("<p><u>First Feature</u>");
			
			// Pick one of the features at random
			$selectedFeature = rand(0, $featureCount-1);
			writeLog("FEATURE: Selected Feature Number: " . $selectedFeature);
			
			// Get the feature name
			$selectedFeatureName = getFeatureName($xml, $selectedFeature);
			writeLog("FEATURE: Selected Feature Name: " . $selectedFeatureName);
			
			// Write out feature name
			echo "<tr><td>" . $selectedFeatureName;
			
			// Update current feature number
			$currentFeature = $selectedFeature;
			writeLog("FEATURE: Set Current Feature to: " . $currentFeature);
			
		} else {
			writeLog("<p><u>Subsequent Feature</u>");
			
			// Pick a feature that's allowed to follow the previous feature
			writeLog("FEATURE: Current Feature Number: " . $currentFeature);
			writeLog("FEATURE: Current Feature Name: " . getFeatureName($xml, $currentFeature));
			
			// Determine how many features may follow the current feature
			$followingFeatures = count($xml->feature[$currentFeature]->following->ff);
			writeLog("FEATURE: Number of Following Features: " . $followingFeatures);	

			// Randomly select a feature
			$selectedFeature = rand(0, $followingFeatures-1);
			writeLog("FEATURE: Selected Feature Number: " . $selectedFeature);
			
			// Get the feature Index
			$selectedFeatureIndex = $xml->feature[$currentFeature]->following->ff[$selectedFeature];
			writeLog("FEATURE: Selected Feature Index: " . $selectedFeatureIndex);

			// Get the feature name
			$selectedFeatureName = getFeatureName($xml, intval($selectedFeatureIndex));
			writeLog("FEATURE: Selected Feature Name: " . $selectedFeatureName);
			
			echo "<tr><td>" . $selectedFeatureName;
			
			// Update current feature number
			$currentFeature = intval($selectedFeatureIndex);
			writeLog("FEATURE: Set Current Feature to: " . $currentFeature);
			
		}
		
		// Get number of options to current feature
		$optionCount = count($xml->feature[$currentFeature]->options->option);
		writeLog("OPTION: Current Feature Options: " . $optionCount);
		
		// Randomly selected a feature
		$selectedOption = rand(0, $optionCount-1);
		writeLog("OPTION: Selected Option Number: " . $selectedOption);
		
		// Get the feature name
		$selectedOptionName = $xml->feature[$currentFeature]->options->option[$selectedOption];
		writeLog("OPTION: Selected Option Name: " . $selectedOptionName);
		
		echo "<td>" . $selectedOptionName . "</tr>";

	}
	
	echo "</table><p>";

}

outputLog();

function getFeatureName($xml, $featureNumber) {
	writeLog(" + getFeatureName(): Feature Number: " . $featureNumber);
	return $xml->feature[$featureNumber]['name'];
}

function writeLog($logMessage) {

	global $debug_log;

	$debug_log = $debug_log . "<br/>" . $logMessage;
}

function outputLog() {

	global $debug_log;

	echo "<p>Debug Log<p>" . $debug_log;
}

?>
