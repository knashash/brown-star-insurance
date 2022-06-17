<?php

namespace BrownStarInsurance;


// Insurance Analysis Tools 


class AnalysisTools
{
	public function get_tiv_values()
	{
		// open the data file for reading
		$file = fopen('/data/FL_insurance_sample.csv', 'r');
	
		$counties = [];
		$lines = [];
		$counter = 0; // using to skip the first header row
		$agg_array = [];

		while (($row = fgetcsv($file)) !== FALSE) {

			// skipping the header row
			$counter++;
			if ($counter == 1) continue;

			// initialize the main variables we need from the row
			$county_name = trim(strtoupper($row[2]));
			$line_type = trim(strtoupper($row[15]));
			$tiv_2012_value = (float) $row[8];

			// add new county to array else add the tiv value to the existing county tiv value
			if (!array_key_exists($county_name, $counties)) $counties[$county_name]['tiv_2012'] = $tiv_2012_value;
			else $counties[$county_name]['tiv_2012'] += $tiv_2012_value;
			
			// add new line to array else add the tiv value to the existing line tiv value
			if (!array_key_exists($line_type, $lines)) $lines[$line_type]['tiv_2012'] = $tiv_2012_value;
			else $lines[$line_type]['tiv_2012'] += $tiv_2012_value;
		}
		fclose($file);

		$agg_array['county'] = $counties;
		$agg_array['line'] = $lines;

		return $agg_array;
	}
}

?>
