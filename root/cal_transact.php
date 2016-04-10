<?php
session_start();
$user_id = $_SESSION['id'];
require './includes/db.inc.php';
require './includes/functions.inc.php';
$group_id = get_group_id($db, $user_id);

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 1: // For displaying the month in calendar.
			define('CAL_HEIGHT', 410); // Height of calendar div.
			$month = $_POST['month'];
			$year = $_POST['year'];
			$today = ($month == date('n') and $year == date('Y')) ?	date('j') : NULL;
			if ($month <= 12 and $month >= 1 and $year >= 1970) {
				$timestamp = mktime(0, 0, 0, $month, 1, $year);
			} else { // Finds the current date. In this case, values of $month and $year from POST method are  both 0.
				$month = date('n');
				$year = date('Y');
				$timestamp = mktime(0, 0, 0, $month, 1, $year);
				$today = date('j');
			}
			$week_start = date('N', $timestamp); // Range: 1 (Monday) through 7 (Sunday).
			$month_name = date('F', $timestamp);
			$total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$sql = 'SELECT e.name, e.start_day, e.start_month, e.start_year, e.is_milestone
							FROM events AS e, groupmembers AS m
							WHERE e.start_year = ' . $year . ' AND e.start_month = ' . $month . ' AND m.id = ' . $user_id . ' AND m.cid = e.group_id';
			$sql_result = mysql_query($sql, $db) or die(mysql_error($db));
			$events = array();
			$event_cnt = 1;
			$event_day = 0;
			while ($row = mysql_fetch_assoc($sql_result)) {
				$event_cnt = ($event_day == $row['start_day']) ? ++$event_cnt : 1;
				$event_day = $row['start_day'];
				$event_name = ($event_cnt > 1) ? $event_cnt . ' events' : $row['name'];
				$events[$event_day] = $event_name;
			}
			$rows = 0; // Rows in calendar can be 4, 5 or 6. This value is needed to calculate the height of table cell.
			for ($i = 1; $i <= $total_days; $rows++) {
				$result .= '<table class="calRow-days"><tr>';
				for ($weekday = 1; $weekday <= 7; $weekday++) {
					$td_count = $weekday + 7 * $rows; // Used to assign unique number to each table cell (incl. those without days).
					$result .= '<td id="d' . $td_count . '">';
					$result .= '<div class="calCell-date"><span>';
					if ($weekday >= $week_start and $i <= $total_days) {
						$result .= $i;
						if ($i == $today) {
							$itoday = $td_count; // $itoday gets the value of the table cell that represents today date.
						}
						$i++;
						$is_it_day = true;
					} else {
						$is_it_day = false;
					}
					$result .= '</span></div>';
					$result .= '<div class="calCell-event"><span>';
					if ($is_it_day and array_key_exists($i - 1, $events)) {
						$result .= $event_name;
					}
					$result .= '</span></div></td>';
				}
				$week_start = 0;
				$result .= '</tr></table>';
			}
			$cell_height = CAL_HEIGHT / $rows;
			$json_array = array(
											'calendar' => $result,
											'cellHeight' => $cell_height,
											'today' => $itoday,
											'monthName' => $month_name,
											'month' => $month,
											'year' => $year
										);
			echo json_encode($json_array);
	}
}
?>