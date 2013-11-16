<?php

/**
 * File name: lib.reparation.php
 * Copyright 2013 Iurie Nistor
 * This file is part of MagSales.
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

function get_repared($date_from, $date_to, $user_id = '', $magazine_id = '')
{
    global $config;

    $query = "SELECT `id`, `name`, `price`, `quantity`, `salary_percent`, 
        CAST(`date` AS DATE) as `date` FROM `".$config['db_prefix']."repared`  
        WHERE CAST(`date` AS DATE) >= '".$date_from."'
        AND `user_id` = '".$user_id."' AND `magazine_id` = '".$magazine_id."' 
        AND CAST(`date` AS DATE) <= '".$date_to."' ORDER BY `date` DESC"; 

    // Select the data.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $products = array();

    // Fetch the result.
    while ($product = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $products[] = $product;
      }

    return $products;
}

/**
 * Save repared product data function.
 *
 * Adds a new repared product to the data base.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_repared()
{
    global $config;

    // Verify name variable.
    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    // Verify price variable.
    if (empty($_POST['price']) && $_POST['price'] != 0)
      {
          return _tr("Price field is empty.");
      }


    // Verify if price variable is numeric.
    if (!is_numeric($_POST['price']))
      {
          return _tr("Price field must be a number.");
      }


    // Verify salary percent variable.
    if (empty($_POST['salary_percent']) && $_POST['salary_percent'] != 0)
      {
          return _tr("Salary percent field is empty.");
      }


    // Verify if salary percent is numeric.
    if (!is_numeric($_POST['salary_percent']))
      {
          return _tr("Salary percent field must be a number.");
      }

    // Create data fields.
    $fields[] = "`name` = '".$_POST['name']."'";
    $fields[] = "`price` = '".$_POST['price']."'";
    $fields[] = "`salary_percent` = '".$_POST['salary_percent']."'";
    if (!empty($_POST['date']))
      { 
          $fields[] = "`date` = '".date('Y-m-d H:i:s', strtotime($_POST['date']))."'";
      }
    else
      {  
          $fields[] = "`date` = '".date('Y-m-d H:i:s')."'";  
      }
    $fields[] = "`magazine_id` = '".$_SESSION['magazine_id']."'";    
    $fields[] = "`user_id` = '".$_SESSION['user_id']."'";    

    // Prepare query for adding new sale to database. 
    $query = "INSERT INTO `".$config['db_prefix']."repared` 
        SET ". implode(', ',$fields);

    // Insert into the database. 
    $result = @mysql_query($query);

    // Verify insertion result.
    if (!$result)
      {
          return _tr("An error occured. The the data have been not saved.");
      } 

    return '';
}


function delete_repared($id)
{
    global $config;

    // Define query.
    $query = "DELETE FROM `".$config['db_prefix']."repared` 
        WHERE `id` = '".$id."'";

    @mysql_query($query);

    if (mysql_affected_rows() < 1) 
      {
          return FALSE;
      }

    return TRUE;
}

