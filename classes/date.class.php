<?php
defined( '_VALID_NVB' ) or die( 'Direct Access to this location is not allowed.' );
 // $Id: date.class.php,v 1.3 2003/12/22 10:41:36 rcastley Exp $
/**
* Date handling class
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License: http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.3 $
**/


class mosDate {
	var $year=null;
	var $month=null;
	var $year=null;
	var $hour=null;
	var $minute=null;
	var $second=null;
	
	function mosEventDate( $datetime='' ) {
		if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})[ ]([0-9]{2}):([0-9]{2}):([0-9]{2})",$datetime,$regs)) {
			$this->setDate( $regs[1], $regs[2], $regs[3] );
			$this->hour   = intval( $regs[4] );
			$this->minute = intval( $regs[5] );
			$this->second = intval( $regs[6] );
			
			$this->month = max( 1, $this->month );
			$this->month = min( 12, $this->month );
			
			$this->day = max( 1, $this->day );
			$this->day = min( $this->daysInMonth(), $this->day );
		} else {
			$this->setDate( date( "Y" ), date( "m" ), date( "d" ) );
			$this->hour   = 0;
			$this->minute = 0;
			$this->second = 0;
		}
	}
	
	function setDate( $year=0, $month=0, $day=0 ) {
		$this->year   = intval( $year );
		$this->month  = intval( $month );
		$this->day    = intval( $day );
		
		$this->month = max( 1, $this->month );
		$this->month = min( 12, $this->month );
		
		$this->day = max( 1, $this->day );
		$this->day = min( $this->daysInMonth(), $this->day );
	}
	
	function getYear( $asString=false ) {
		return $asString ? sprintf( "%04d", $this->year ) : $this->year;
	}
	
	function getMonth( $asString=false ) {
		return $asString ? sprintf( "%02d", $this->month ) : $this->month;
	}
	
	function getDay( $asString=false ) {
		return $asString ? sprintf( "%02d", $this->day ) : $this->day;
	}
	
	function toDateURL() {
		return( 'year=' . $this->getYear( 1 )
		. '&month=' . $this->getMonth( 1 )
		. '&day=' . $this->getDay( 1 )
		);
	}
	/**
	* Utility function for calculating the days in the month
	*
	* If no parameters are supplied then it uses the current date
	* if 'this' object does not exist
	* @param int The month
	* @param int The year
	*/
	function daysInMonth( $month=0, $year=0 ) {
		$month = intval( $month );
		$year = intval( $year );
		if (!$month) {
			if (isset( $this )) {
				$month = $this->month;
			} else {
				$month = date( "m" );
			}
		}
		if (!$year) {
			if (isset( $this )) {
				$year = $this->year;
			} else {
				$year = date( "Y" );
			}
		}
		if ($month == 2) {
			if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
				return 29;
			} else {
				return 28;
			}
		} else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
			return 30;
		} else {
			return 31;
		}
	}
	/**
	* Adds (+/-) a number of months to the current date.
	* @param int Positive or negative number of months
	* @author Andrew Eddie <eddieajau@users.sourceforge.net>
	*/
	function addMonths( $n=0 ) {
		$an = abs( $n );
		$years = floor( $an / 12 );
		$months = $an % 12;
		
		if ($n < 0) {
			$this->year -= $years;
			$this->month -= $months;
			if ($this->month < 1) {
				$this->year--;
				$this->month = 12 - $this->month;
			}
		} else {
			$this->year += $years;
			$this->month += $months;
			if ($this->month > 12) {
				$this->year++;
				$this->month -= 12;
			}
		}
	}
	
	function addDays( $n=0 ) {
		$days = $this->toDays();
		$this->fromDays( $days + $n );
	}
	/**
	* Converts a date to number of days since a
	* distant unspecified epoch.
	*
	* !!Based on PEAR library function!!
	* @param string year in format CCYY
	* @param string month in format MM
	* @param string day in format DD
	* @return integer number of days
	*/
	function toDays( $day=0, $month=0, $year=0) {
		if (!$day) {
			if (isset( $this )) {
				$day = $this->day;
			} else {
				$day = date( "d" );
			}
		}
		if (!$month) {
			if (isset( $this )) {
				$month = $this->month;
			} else {
				$month = date( "m" );
			}
		}
		if (!$year) {
			if (isset( $this )) {
				$year = $this->year;
			} else {
				$year = date( "Y" );
			}
		}
		
		$century = floor( $year / 100 );
		$year = $year % 100;
		
		if($month > 2) {
			$month -= 3;
		} else {
			$month += 9;
			if ($year) {
				$year--;
			} else {
				$year = 99;
				$century --;
			}
		}
		
		return ( floor( (146097 * $century) / 4 ) +
		floor( (1461 * $year) / 4 ) +
		floor( (153 * $month + 2) / 5 ) +
		$day + 1721119
		);
	} // end func dateToDays
	
	/**
	* Converts number of days to a distant unspecified epoch.
	*
	* !!Based on PEAR library function!!
	* @param int number of days
	* @param string format for returned date
	*/
	function fromDays( $days ) {
		
		$days -=   1721119;
		$century =    floor( ( 4 * $days - 1) /  146097 );
		$days =    floor( 4 * $days - 1 - 146097 * $century );
		$day =    floor( $days /  4 );
		
		$year =    floor( ( 4 * $day +  3) /  1461 );
		$day =    floor( 4 * $day +  3 -  1461 * $year );
		$day =    floor( ($day +  4) /  4 );
		
		$month = floor( ( 5 * $day -  3) /  153 );
		$day = floor( 5 * $day -  3 -  153 * $month );
		$day = floor( ($day +  5) /  5 );
		
		if ($month < 10) {
			$month +=3;
		} else {
			$month -=9;
			if ($year++ == 99) {
				$year = 0;
				$century++;
			}
		}
		
		$this->day = $day;
		$this->month = $month;
		$this->year = $century*100 + $year;
	} // end func daysToDate
}
?>