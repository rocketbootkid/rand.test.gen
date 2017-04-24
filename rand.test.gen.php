<?php

$xml = simplexml_load_file("config.xml");

$featureCount = count($xml->feature);

$suiteCount = 20;
$minSuiteLength = 3;
$maxSuiteLength = 20;


for ($s = 0; $s < $suiteCount; $s++) {

	echo "<p><strong>Suite " . $s . "</strong><br/>";

	$currentFeature = -1;
	
	$testsInSuite = rand($minSuiteLength, $maxSuiteLength);

	for ($t = 0; $t < $testsInSuite; $t++) {

		// Select Feature
		if ($currentFeature == "") {
			$selectedFeature = rand(0, $featureCount-1);
			$selectedFeatureName = $xml->feature[$selectedFeature]['name'];
			echo $selectedFeatureName . " - ";
			$currentFeature = $selectedFeature;
		} else {
			//echo "ELSE<br/>";
			// Pick a feature that's allowed to follow the previous feature
			$followingFeatures = count($xml->feature[$currentFeature]->following->ff);
			//echo " + There are " . $followingFeatures . " features that can follow the current one.<br/>";
			$selectedFeature = rand(0, $followingFeatures-1);
			//echo "Selected Feature: " . $selectedFeature . "<br/>";
			$selectedFeatureName = $xml->feature[$currentFeature]->following->ff[$selectedFeature];
			echo $selectedFeatureName . " - ";
			$currentFeature = $selectedFeature;			
		
		}
		
		// Select Option
		$optionCount = count($xml->feature[$selectedFeature]->options->option);
		$selectedOption = rand(0, $optionCount-1);
		$selectedOptionName = $xml->feature[$selectedFeature]->options->option[$selectedOption];
		echo $selectedOptionName . "<br/>";

	}

}

?>