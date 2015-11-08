<?php

/**
 * File name: lib.fabrication.php
 * Copyright 2013 Iurie Nistor
 * This file is part of MagVendo.
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

function mag_get_fabricated($args = array())
{
    global $config;

    $conditions = array();

    if (isset($args['date_from'])) {
        $conditions[] = "CAST(`f.date` AS DATE) >= '". $args['date_from'] . "'";
    }
    if (isset($args['date_to'])) {
        $conditions[] = "CAST(`f.date` AS DATE) <= '". $args['date_to'] . "'";
    }
    if (isset($args['user'])) {
        $conditions[] = "CAST(`f.date` AS DATE) <= '". $args['user'] . "'";
    }
    if (isset($args['magazine'])) {
        $conditions[] = "CAST(`f.date` AS DATE) <= '". $args['magazine'] . "'";
    }

    if (empty($conditions)) {
        $conditions = '';
    }
    else {
        $conditions = implode(" AND ", $conditions);
    }  

    $query = "SELECT f.id as product_id, f.name as product_name, f.quantity, f.salary,
        m.id as magazine_id, m.name as magazine_name, u.id as user_id,
        u.name as worke_name, CAST(f.date AS DATE) as date 
        FROM " . $config['db_prefix'] . "fabricated f
        LEFT JOIN " . $config['db_prefix'] . "magazines m
        ON f.magazine_id = m.id
        LEFT JOIN " . $config['db_prefix'] . "users u
        ON f.user_id = u.id "
        . " WHERE " . $conditions 
        ." ORDER BY date DESC"; 
    echo $query;
    $result = @mysql_query($query); 

    if (!$result) {
        return array();
    }  

    $products = array();

    while ($product = @mysql_fetch_array($result, MYSQL_ASSOC)) {
        $products[] = $product;
    }

    return $products;
}

// Depricated function
function get_fabricated($date_from, $date_to, $user_id = '', $magazine_id = '')
{
    global $config;

    $query = "SELECT `id`, `name`, `price`, `quantity`, `salary`, 
        CAST(`date` AS DATE) as `date` FROM `".$config['db_prefix']."fabricated`  
        WHERE CAST(`date` AS DATE) >= '".$date_from."'
        AND `user_id` = '" . $user_id . "' AND `magazine_id` = '" . $magazine_id."' 
        AND CAST(`date` AS DATE) <= '" . $date_to . "' ORDER BY `date` DESC"; 

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
 * Save fabricated product data function.
 *
 * Adds a new fabricated product to the data base.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_fabricated()
{
    global $config;

    // Verify name variable.
    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    if (empty($_POST['price'])) {
        return _tr("Price field is empty.");
    }

    if (!is_numeric($_POST['price'])) {
        return _tr("Price must be numberic");
    }

    // Verify salary variable.
    if (empty($_POST['quantity']) && $_POST['quantity'] != 0)
      {
          return _tr("Quantity field is empty.");
      }

    // Verify if salary is numeric.
    if (!is_numeric($_POST['quantity']))
      {
          return _tr("Quantity field must a number.");
      }

    // Verify salary variable.
    if (empty($_POST['salary']) && $_POST['salary'] != 0)
      {
          return _tr("Salary field is empty.");
      }

    // Verify if salary is numeric.
    if (!is_numeric($_POST['salary']))
      {
          return _tr("Salary field must be a real number.");
      }

    // Create data fields.
    $fields[] = "`name` = '".$_POST['name']."'";
    $fields[] = "`price` = '" . $_POST['price'] . "'";
    $fields[] = "`quantity` = '".$_POST['quantity']."'";
    $fields[] = "`salary` = '".$_POST['salary']."'";
    if (!empty($_POST['date']))
      { 
          $fields[] = "`date` = '".date('Y-m-d H:i:s', strtotime($_POST['date']))."'";
      }
    else
      {  
          $fields[] = "`date` = '".date('Y-m-d H:i:s')."'";  
      }
    $fields[] = "`magazine_id` = '".$_SESSION['magvendo']['magazine_id']."'";    
    $fields[] = "`user_id` = '".$_SESSION['magvendo']['user_id']."'";    

    // Prepare query. 
    $query = "INSERT INTO `".$config['db_prefix']."fabricated` 
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

function delete_fabricated($id)
{
    global $config;

    // Define query.
    $query = "DELETE FROM `".$config['db_prefix']."fabricated` 
        WHERE `id` = '".$id."'";

    @mysql_query($query);

    if (mysql_affected_rows() < 1) 
      {
          return FALSE;
      }

    return TRUE;
}


