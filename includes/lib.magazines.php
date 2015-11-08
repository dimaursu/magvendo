<?php

/**
 * File name: lib.magazines.php
 * Copyright 2013 Iurie Nistor
 * This file is part of MgSales.
 *
 * MagVendo is free software; you can redistribute it and/or modify
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
 * Get magazine function.
 * 
 * Gets a magazine data from the database by its id.
 *
 * @param $id
 *   User id.
 *
 * @return
 *   Return an array contaning magazine data, otherwise it return an empty array.
 */
function get_magazine($id)
{
    global $config;

    // Verify magazine id.
    if (!is_numeric($id))
      {
          return array();
      }

    // Define SQl request query.
    $query = "SELECT * FROM `".$config['db_prefix']."magazines` 
    WHERE `id` = '".$id."'";
           
    // Select data.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return array();
     }  

    // Fetch the result.
    $magazine = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $magazine;
}

function get_magazines($page = '', $args = array(), $items_per_page = 10)
{
    global $config;

    $limit = '';

    if (!empty($page) && is_numeric($page) && $page > 0)
      {
          $limit = " LIMIT ".($page-1)*$items_per_page.", ".$items_per_page;
      }

    // Define request query.
    $query = "SELECT * FROM `".$config['db_prefix']."magazines` 
             ORDER BY `name` ASC" . $limit;

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
    while ($magazine = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $magazines[] = $magazine;
      }

    return $magazines;
}

function mags_save_magazine()
{
    global $config;

    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    $fields[] = "name = '" . $_POST['name'] . "'";

    if (!empty($_POST['description']))
      {
          $fields[] = "description = '".$_POST['description']."'";
      }

    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          $query = "INSERT INTO ".$config['db_prefix']."magazines
              SET " . implode(', ', $fields);
      }
    else
     {
         $query = "UPDATE " . $config['db_prefix'] . "magazines
             SET " . implode(', ', $fields)." WHERE id = '".$_GET['id']."'";
     }

    $result = @mysql_query($query);

    if (!$result)
      {
          return _tr("An error occured. The magainze is not saved.");
      }

    return '';
}

function magazines_number($args = array())
{
    global $config;


    // Define request query with category.
    $query = "SELECT COUNT(*) as `number` 
        FROM `".$config['db_prefix']."magazines`";

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

function remove_magazine($id)
{
    global $config;

    // Define query.
    $query = "DELETE FROM `".$config['db_prefix']."magazines` 
        WHERE `id` = '".$id."'";

    @mysql_query($query);
}
