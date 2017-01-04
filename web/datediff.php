<?php
//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate,$endDate,$holidays){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
}

//Example:

$holidays=array("2013-03-16","2013-03-17","2013-03-23","2013-03-24","2013-03-30","2013-03-31","2013-04-06","2013-04-07","2013-04-13","2013-04-14","2013-04-20","2013-04-21","2013-04-27","2013-04-28","2013-05-04","2013-05-05","2013-05-11","2013-05-12","2013-05-18","2013-05-19","2013-05-25","2013-05-26","2013-05-25","2013-06-01","2013-06-02","2013-06-08","2013-06-09","2013-06-15","2013-06-22","2013-06-23","2013-06-29","2013-06-30","2013-07-06","2013-07-07","2013-07-13","2013-07-14","2013-07-20","2013-07-21","2013-07-27","2013-07-28","2013-08-03","2013-08-04","2013-08-04","2013-08-10","2013-08-11","2013-08-17","2013-08-18","2013-08-24","2013-08-25","2013-09-07","2013-09-08","2013-09-14","2013-09-15","2013-09-21","2013-09-28","2013-09-29","2013-10-05","2013-10-06","2013-10-12","2013-10-13","2013-10-19","2013-10-20","2013-10-26","2013-11-02","2013-11-02","2013-11-03","2013-11-09","2013-11-10","2013-11-16","2013-11-17","2013-11-23","2013-11-24","2013-11-30","2013-12-01","2013-12-07","2013-12-08","2013-12-14","2013-12-15","2013-12-21","2013-12-22","2013-12-28","2013-12-29");

//echo getWorkingDays("2013-04-04","2013-04-10",$holidays)
// => will return 7
?>