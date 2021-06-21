<?php

namespace App\Service;

class SortAndLimitArray
{

    public function runService($dumps, $dayLimit)
    {
        if($dayLimit == null){ 
            $dayLimit = 30;
        }
        // get creation date of each dump in 'd/m/Y' format and add it as key to $dumpsByCreationDate 
        // then count each dump with that date store the sum as value for that date
        $dumpsByCreationDate = [];

        $newDateTime = new \DateTime();

        $todayTimestamp = $newDateTime->getTimeStamp();
        // $today = date("d/m/Y", $todayTimestamp);

        $dumpsByCreationDatestamp[] = $todayTimestamp;

        // one day in seconds
        $oneDay = 86400;

        // create table of timestamps
        for($day = 1; $day < $dayLimit; $day += 1){
            $dumpsByCreationDatestamp[] = $dumpsByCreationDatestamp[$day - 1] - $oneDay;
        }

        // initialize table with date in d/m/Y format
        $dumpsByCreationDate = [];

        // populate d/m/Y table
        foreach($dumpsByCreationDatestamp as $creationDate){
            // $dumpsByCreationDate[] = date("d/m/Y", $creationDate);            
            $dumpsByCreationDate[] = $creationDate;            
        }

        // sort d/m/Y table in ASC order
        // dump($dumpsByCreationDate);
        sort($dumpsByCreationDate);
        // dump($dumpsByCreationDate);

        // initialize new table with d/m/Y values as keys for associative array
        $dumpsByCreationDateForChart = [];

        // populate associative d/m/Y table
        foreach($dumpsByCreationDate as $creationDate){
            // dd($creationDate);
            // dd($creationDate['mday'] . '/' . $creationDate['mon'] . '/' . $creationDate['year']);

            $dumpsByCreationDateForChart[date('d/m/Y', $creationDate)] = 0;
        }

        // dd($dumpsByCreationDateForChart);

        // populate associative d/m/Y table values with dates in $dumps list
        foreach($dumps as $dump){
            $dumpDate = date("d/m/Y", $dump->getCreatedAt()->getTimestamp());

            if(key_exists($dumpDate, $dumpsByCreationDateForChart)){
                $dumpsByCreationDateForChart[$dumpDate] += 1;

            } 

        }

        return $dumpsByCreationDateForChart;

    }


}