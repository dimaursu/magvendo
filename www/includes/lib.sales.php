<?php

/**
 * File name: lib.sales.php
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

function get_sales($date_from, $date_to, $user_id = '', $magazine_id = '')
{
    global $config; 

    if (!empty($user_id) && !empty($magazine_id))
      {
          // Prepare query to get the user sales from a magazine. 
          $query = "SELECT `id`, `name`, `price`, `quantity`, 
             `discount`, `magazine_id`, `user_id`, CAST(`date` AS DATE) as `date` 
              FROM `".$config['db_prefix']."sales`  
              WHERE CAST(`date` AS DATE) >= '".$date_from."'
              AND `user_id` = '".$user_id."' AND `magazine_id` = '".$magazine_id."' 
              AND CAST(`date` AS DATE) <= '".$date_to."' ORDER BY `date` DESC";   
      }
    else if (empty($user_id) && !empty($magazine_id))
     {
          // Prepare query to get the sales from a magazine. 
          $query = "SELECT `id`, `name`, `price`, `quantity`, `discount`,
              `magazine_id`, `user_id`, CAST(`date` AS DATE) as `date` 
              FROM `".$config['db_prefix']."sales`  
              WHERE CAST(`date` AS DATE) >= '".$date_from."'
              AND `magazine_id` = '".$magazine_id."' 
              AND CAST(`date` AS DATE) <= '".$date_to."' ORDER BY `date` DESC";   
     }
    else if (!empty($user_id) && empty($magazine_id))
     {
          // Prepare query to get the users sales from all magazines. 
          $query = "SELECT `id`, `name`, `price`, `quantity`, `discount`, 
              `magazine_id`, `user_id`, CAST(`date` AS DATE) as `date` 
              FROM `".$config['db_prefix']."sales`  
              WHERE CAST(`date` AS DATE) >= '".$date_from."'
              AND `user_id` = '".$user_id."' 
              AND CAST(`date` AS DATE) <= '".$date_to."' ORDER BY `date` DESC"; 
     }
    else
     {
          // Prepare query to get all sales from all magazines. 
          $query = "SELECT `id`, `name`, `price`, `quantity`, `discount`,
              `magazine_id`, `user_id`, CAST(`date` AS DATE) as `date` 
              FROM `".$config['db_prefix']."sales`  
              WHERE CAST(`date` AS DATE) >= '".$date_from."'
              AND CAST(`date` AS DATE) <= '".$date_to."' ORDER BY `date` DESC"; 
     }

    // Select sales.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $sales = array();

    // Fetch the result.
    while ($sale = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $sales[] = $sale;
      }

    return $sales;
}

/**
 * Sales sum function.
 * 
 * Gets the sum of the sales by period in one magazine.
 *
 * @param $date_from
 *   Begin of the period.
 *
 * @param $date_to
 *   End of the period.
 *
 * @param $magazine_id
 *   Magazine id for which to get the sales sum.
 *
 * @return
 *   Returns the sum (a number) of sales per period.
 */
function sales_sum($date_from, $date_to, $magazine_id)
{

    global $config;

    // Prepare query to get the user sales. 
    $query = "SELECT `price`, `quantity`, `discount`, 
        CAST(`date` AS DATE) as `date` FROM `".$config['db_prefix']."sales`  
        WHERE CAST(`date` AS DATE) >= '".$date_from."'
        AND CAST(`date` AS DATE) <= '".$date_to."'
        AND `magazine_id` = '".$magazine_id."'"; 

    // Select sales.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         return 0;
     }  

    $sum = 0;

    // Fetch the result.
    while ($sale = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $sum += $sale['quantity'] * 
              $sale['price'] * 
              (1-0.01*$sale['discount']);
      }

    return $sum;
}


/**
 * Save sold product data function.
 *
 * Adds a new sold product to the data base.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_sale()
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
          return _tr("Price field must by a number.");
      }


     // Create data fields.
    $fields[] = "`name` = '".$_POST['name']."'";
    $fields[] = "`price` = '".$_POST['price']."'";
    if (!empty($_POST['quantity']) && is_numeric($_POST['quantity']))
      {
          $fields[] = "`quantity` = '".$_POST['quantity']."'";
      }
    if (!empty($_POST['discount']) && is_numeric($_POST['quantity']))
      {
          $fields[] = "`discount` = '".$_POST['discount']."'";
      }
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

    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          // Prepare query for adding new sale to database. 
          $query = "INSERT INTO `".$config['db_prefix']."sales` 
              SET ". implode(', ',$fields);
      }
    else
     {
         // Prepare query for update a sale data.
         $query = "UPDATE `".$config['db_prefix']."sales` 
             SET ". implode(', ',$fields)." WHERE `id` = '".$_GET['id']."'";
     }

    // Insert into the database. 
    $result = @mysql_query($query);

    // Verify insertion result.
    if (!$result)
      {
          return _tr("An error occured. The the sale data have been not saved.");
      } 

    return '';
}

function delete_sale($id)
{
    global $config;

    // Define query.
    $query = "DELETE FROM `".$config['db_prefix']."sales` 
        WHERE `id` = '".$id."'";

    @mysql_query($query);

    if (mysql_affected_rows() < 1) 
      {
          return FALSE;
      }

    return TRUE;
}
