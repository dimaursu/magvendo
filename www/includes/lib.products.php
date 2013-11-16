<?php

/**
 * File name: lib.products.php
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
 * Get product function.
 * 
 * Gets a product from the database by its id.
 *
 * @param $id
 *   User id.
 *
 * @return
 *   Return an array contaning the product data, otherwise it return an empty array.
 */
function get_product($id)
{
    global $config;

    // Verify product id.
    if (!is_numeric($id))
      {
          return array();
      }

    // Define SQl request query.
    $query = "SELECT * FROM `".$config['db_prefix']."products` 
    WHERE `id` = '".$id."'";
           
    // Select product.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return array();
     }  

    // Fetch the result.
    $product = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $product;
}

function get_products($page = '', $args = array(), $items_per_page = 10)
{
    global $config;

    $limit = '';

    if (!empty($page) && is_numeric($page) && $page > 0)
      {
          $limit = " LIMIT ".($page-1)*$items_per_page.", ".$items_per_page;
      }

    // Verfy category argument.
    if (!empty($args['category']) && is_numeric($args['category']))
      {
          $conditions[] = "`category_id` = '".$args['category']."'";
      }

    // Verify search variable.
    if (!empty($args['search']))
      {
          $conditions[] = "`name` LIKE '%".$args['search']."%'";
      }

    // Verify archive variable.
    if (!empty($args['archive']))
      {
          $conditions[] = "`archived`= '1'";
      }
    else
      {
          $conditions[] = "`archived`= '0'";
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
    $query = "SELECT * FROM `".$config['db_prefix']."products` ".$conditions."
             ORDER BY `name` ASC".$limit;

    // Select products.
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

function products_number($args = array())
{
    global $config;

    // Verfy category argument.
    if (!empty($args['category']) && is_numeric($args['category']))
      {
          $conditions[] = "`category_id` = '".$args['category']."'";
      }

    // Verify search variable.
    if (!empty($args['search']))
      {
          $conditions[] = "`name` LIKE '%".$args['search']."%'";
      }

    // Verify archive variable.
    if (!empty($args['archive']))
      {
          $conditions[] = "`archived`= '1'";
      }
    else
      {
          $conditions[] = "`archived`= '0'";
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
    $query = "SELECT COUNT(*) as `number` 
        FROM `".$config['db_prefix']."products` ".$conditions;

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
 * Add product function.
 *
 * Adds a new product in the database.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_product()
{
    global $config;

    // Verify name variable.
    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    // Verify price variable.
    if (empty($_POST['price']))
      {
          return _tr("Price field is empty.");
      }

    // Verify if price is number.
    if (!is_numeric($_POST['price']))
      {
          return _tr("Price should be a number.");
      }


    // Verify price variable.
    if (empty($_POST['quantity']))
      {
          return _tr("Quantity field is empty.");
      }

    // Verify if price is number.
    if (!is_numeric($_POST['quantity']))
      {
          return _tr("Quantity should be a number.");
      }

    // Create data array.
    $fields[] = "`name` = '".$_POST['name']."'";
    $fields[] = "`price` = '".$_POST['price']."'";
    $fields[] = "`quantity` = '".$_POST['quantity']."'";
    $fields[] = "`category_id` = '".$_POST['category']."'";
    if (!empty($_POST['description']))
      {
          $fields[] = "`description` = '".$_POST['description']."'";
      }
    if (isset($_POST['archived']))
      {
          $fields[] = "`archived` = '".(1)."'";
      }
    else
      {
          $fields[] = "`archived` = '".(0)."'";
      }

    $fields[] = "`registered_date` = '".date('Y-m-d H:i:s')."'";

    // Verify product id variable.
    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          // Prepare query for adding a new product. 
          $query = "INSERT INTO `".$config['db_prefix']."products` 
              SET ". implode(', ',$fields);
      }
    else
     {
         // Prepare query for product update.
         $query = "UPDATE `".$config['db_prefix']."products` 
             SET ". implode(', ',$fields)." WHERE `id` = '".$_GET['id']."'";
     }
    
    // Execute query. 
    $result = @mysql_query($query);

    // Verify insertion result.
    if (!$result)
      {
          return _tr("An error occured. The product was not saved.");
      } 

    return '';
}

function archive_product($id, $archived = FALSE)
{    
    global $config;

    // Verify id variable
    if (!isset($id) || !is_numeric($id))
      {
          return FALSE;
      }

    // Prepare query for product update.
    $query = "UPDATE `".$config['db_prefix']."products` 
             SET `archived` = '".$archived."' WHERE `id` = '".$id."'";
    
    // Execute query. 
    $result = @mysql_query($query);

    // Verify result.
    if (!$result)
      {
          return FALSE;
      } 

    return TRUE;    
}
