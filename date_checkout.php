<?php 
 //This gets today's date 
 $date = time(); 
 
 //This puts the day, month, and year in seperate variables 
 $month_select = date('n', $date) ;
 $year_select = date('Y', $date) ;
 
 if(isset($_GET['json'])){
 $date_select = json_decode($_GET['json'], true);
 $month_select = $date_select['month_select'];
 $year_select = $date_select['year_select'];
 }
 
 //Here we generate the first day of the month 
 $first_day = mktime(0,0,0,$month_select, 1, $year_select) ; 

 //This gets us the month name 
 $title_select = date('F', $first_day) ; 
 //Here we find out what day of the week the first day of the month falls on 
 $day_of_week = date('D', $first_day) ;
  
 //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
 
 switch($day_of_week){ 
 case "Sun": $blank = 0; break; 
 case "Mon": $blank = 1; break; 
 case "Tue": $blank = 2; break; 
 case "Wed": $blank = 3; break; 
 case "Thu": $blank = 4; break; 
 case "Fri": $blank = 5; break; 
 case "Sat": $blank = 6; break; 
 }

 //We then determine how many days are in the current month
 $days_in_month = cal_days_in_month(0, $month_select, $year_select) ; 
 
 //Here we start building the table heads 
 echo "<table width=210>";
 echo "<tr><th colspan=7>
 <div class='last_month' onclick=last_month_checkout(".$month_select.",".$year_select.")><<</div>
 <div class='current_month'>$title_select $year_select</div>
 <div class='next_month' onclick=next_month_checkout(".$month_select.",".$year_select.")>>></div></th></tr>";
 echo "<tr><td width=30>S</td><td width=30>M</td><td width=30>T</td><td width=30>W</td><td width=30>T</td><td width=30>F</td><td width=30>S</td></tr>";

 //This counts the days in the week, up to 7
 $day_count = 1;
 
 echo "<tr>";

 //first we take care of those blank days
 while ( $blank > 0 ) 
 { 
 echo "<td></td>"; 
 $blank = $blank-1; 
 $day_count++;
 } 

//sets the first day of the month to 1 
 $day_num = 1;

 //count up the days, untill we've done all of them in the month
 while ( $day_num <= $days_in_month ) 
 { 
 echo "<td><a onclick=change_checkout_selector_value(".$day_num.",".$month_select.",".$year_select.")>$day_num</a></td>"; 
 $day_num++; 
 $day_count++;

 //Make sure we start a new row every week
 if ($day_count > 7)
 {
 echo "</tr><tr>";
 $day_count = 1;
 }
 
 } 
 
//Finaly we finish out the table with some blank details if needed
 while ( $day_count >1 && $day_count <=7 ) 
 { 
 echo "<td></td>"; 
 $day_count++; 
 } 
 
 echo "</tr></table>"; 
 
 ?>