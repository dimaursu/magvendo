<?php

/**
 * File name: lib.categories.php
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


/**
 * Get category function.
 * 
 * Gets a category from the database by its id.
 *
 * @param $id
 *   User id.
 *
 * @return
 *   Return an array contaning category data, otherwise it return an empty array.
 */
function get_category($id)
{
    global $config;

    // Verify category id.
    if (!is_numeric($id))
      {
          return array();
      }

    // Define SQl request query.
    $query = "SELECT * FROM `".$config['db_prefix']."categories` 
    WHERE `id` = '".$id."'";
           
    // Select data.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return array();
     }  

    // Fetch the result.
    $category = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $category;
}

function get_categories($page = '', $args = array(), $items_per_page = 10)
{
    global $config;

    $limit = '';

    if (!empty($page) && is_numeric($page) && $page > 0)
      {
          $limit = " LIMIT ".($page-1)*$items_per_page.", ".$items_per_page;
      }

    // Verify conditions.
    if (empty($conditions))
      {
          $conditions = '';
      }
    else
     {
          $conditions = " WHERE ".implode(" AND ", $conditions);
     }  

    // Define request query with category.
    $query = "SELECT * FROM `".$config['db_prefix']."categories` 
             ORDER BY `name` ASC".$limit;

    // Select data.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $vendors = array();

    // Fetch the result.
    while ($category = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $categories[] = $category;
      }

    return $categories;
}


function categories_number($args = array())
{
    global $config;


    // Define request query with category.
    $query = "SELECT COUNT(*) as `number` 
        FROM `".$config['db_prefix']."categories`";

    // Select products.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return 0;
     }

    $number = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $number['number'];
}

/**
 * Add category function.
 *
 * Adds a new category in the database.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_category()
{
    global $config;

    // Verify name variable.
    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    // Create data array.
    $fields[] = "`name` = '".$_POST['name']."'";
    if (!empty($_POST['description']))
      {
          $fields[] = "`description` = '".$_POST['description']."'";
      }

    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          // Prepare query for adding a new product. 
          $query = "INSERT INTO `".$config['db_prefix']."categories` 
              SET ". implode(', ',$fields);
      }
    else
     {
         // Prepare query for product update.
         $query = "UPDATE `".$config['db_prefix']."categories` 
             SET ". implode(', ',$fields)." WHERE `id` = '".$_GET['id']."'";
     }

    // Insert into the database. 
    $result = @mysql_query($query);

    // Verify insertion result.
    if (!$result)
      {
          return _tr("An error occured. The category have been not saved.");
      } 

    return '';
}

function remove_category($id)
{
    global $config;

    // Define query.
    $query = "DELETE FROM `".$config['db_prefix']."categories` 
        WHERE `id` = '".$id."'";

    @mysql_query($query);
}

function get_months($from, $to)
{
     $date = $from;
     while (strtotime($date) < strtotime($to))
        {
            $months[] = date('Y-m', strtotime($date));
	    $newdate = strtotime('+1 month', strtotime($date));
            $date = date('Y-m-d', $newdate);
	 }

    return $months;
}
