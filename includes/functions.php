<?php

/**
 * File name: functions.php
 * Copyright 2013 Iurie Nistor
 * This file is part of LightStore.
 *
 * LightStore is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

function _tr($text)
{
    global $language;
    //echo $text;

    // Verify translation.
    if (empty($language[$text]))
      {
          // Print original text.
          return $text; 
      }
    else
     {
         // Print translated text.
         return $language[$text];
     }
}

function _e($text)
{
    echo _tr($text);
}

/**
 * Pagination function.
 *
 * Gets the pagination.
 *
 * @param $current_page
 *   The current page number.
 * @param $items_numer
 *   The number of all items.
 * @param $max_per_page.
 *   The numebr of maximum items per page.
 * @param $url
 *   The url of page without page number parameter.
 *
 * @return
 *   Returns a string in HTML format contaning the pagination.
 */
function pagination($current_page, $items_number, $max_per_page, $url)

{

    // Maximum page links per page. 
    $max_pagelinks = 10;

    // Calculate pages number.
    $pages_number = ceil($items_number/$max_per_page);

    //Verify pages numbers.
    if ( $pages_number < 2 ) return "";

    // Verify current page.
    if( $current_page < 1 || $current_page > $pages_number ) return "";

    // Calculate from page.
    $from = floor( ($current_page - 1)/$max_pagelinks ) * $max_pagelinks + 1;

    // Calculate prev page.
    $prev = $from - 1;

    // Calculate to page.
    $to = $from + $max_pagelinks - 1;

    if( $to > $pages_number ) $to = $pages_number;
    // Calculate next page.

    $next = $to + 1; 
    $pagination = '<ul class="pagination">';

    // Check whether to create perv link.

    if(  $prev > 1 ) $pagination .= '<li><a href="'.$url.'&page='.$prev.'"><<</a></li>';

    // Create pages links.
    for ( $i = $from; $i <= $to; $i++ )
      {
          if ( $i != $current_page ) $pagination .= '<li><a href="'.$url.'&page='.$i.'">'.$i.'</a></li>'; 
          else $pagination .= '<li><a class="current-page" href="'.$url.'&page='.$i.'">'.$i.'</a></li>';
      }

   // Check whether to create next link.
    if( $next < $pages_number ) $pagination .= '<li><a href="'.$url.'&page='.$next.'">>></a></li>';  

   $pagination .="</ul>";

   // Print pagination;
   echo $pagination;    

}

function real_escape($string)
{
    // Verify whether magic quotes is enabled.
    if (get_magic_quotes_gpc())
      {
          // Strip slashes and return the escaped string. 
          return mysql_real_escape_string(stripslashes($string));

      }
    else 
      {
          // Returns the escaped string. 
          return mysql_real_escape_string($string);
      }
}
