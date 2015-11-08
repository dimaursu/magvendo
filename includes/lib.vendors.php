<?php

/**
 * File name: lib.vendors.php
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


/**
 * Get vendor function.
 * 
 * Gets a vendor from the database by its id.
 *
 * @param $id
 *   User id.
 *
 * @return
 *   Return an array contaning vendor data, otherwise it return an empty array.
 */
function get_vendor($id)
{
    global $config;

    // Verify user id.
    if (!is_numeric($id))
      {
          return array();
      }

    // Define SQl request query.
    $query = "SELECT * FROM `".$config['db_prefix']."vendors` 
    WHERE `id` = '".$id."'";
           
    // Select vendors.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return array();
     }  

    // Fetch the result.
    $vendor = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $vendor;
}

function get_vendors($page = '', $args = array(), $items_per_page = 10)
{
    global $config;

    $limit = '';

    if (!empty($page) && is_numeric($page) && $page > 0)
      {
          $limit = " LIMIT ".($page-1)*$items_per_page.", ".$items_per_page;
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

    // Define request query.
    $query = "SELECT * FROM `".$config['db_prefix']."vendors` 
        ".$conditions." ORDER BY `name` ASC".$limit; 

    // Execute query.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $vendors = array();

    // Fetch the result.
    while ($vendor = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $vendors[] = $vendor;
      }

    return $vendors;
}

function vendors_number($args = array())
{
    global $config;

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
        FROM `".$config['db_prefix']."vendors` ".$conditions;

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
 * Add vendor function.
 *
 * Adds a new vendor in the database.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_vendor()
{
    global $config;

    // Verify name variable.
    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    // Create data array.
    $fields[] = "`name` = '".$_POST['name']."'";
    if (!empty($_POST['email']))
      {
          $fields[] = "`email` = '".$_POST['email']."'";
      }
    if (!empty($_POST['phone']))
      {
          $fields[] = "`phone` = '".$_POST['phone']."'";
      }
    if (!empty($_POST['address']))
      {
          $fields[] = "`address` = '".$_POST['address']."'";
      }
    if (!empty($_POST['description']))
      {
          $fields[] = "`description` = '".$_POST['description']."'";
      }
    $fields[] = "`registered_date` = '".date('Y-m-d H:i:s')."'";

    // Verify vendor id variable.
    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          // Prepare query for adding a new product. 
          $query = "INSERT INTO `".$config['db_prefix']."vendors` 
              SET ". implode(', ',$fields);
      }
    else
     {
         // Prepare query for product update.
         $query = "UPDATE `".$config['db_prefix']."vendors` 
             SET ". implode(', ',$fields)." WHERE `id` = '".$_GET['id']."'";
     }

    // Insert into the database. 
    $result = @mysql_query($query);

    // Verify insertion result.
    if (!$result)
      {
          return _tr("An error occured. The vendor was not saved.");
      } 

    return '';
}

/**
 * Add vendor product function.
 *
 * Add new products to vendor's products list.
 *
 * @return
 *   Returns a string contaning the error, othewise returns and empty string.
 */
function add_vendor_product($vendor_id)
{
    global $config;

    // Get product by its id.
    $product = get_product($_POST['product_id']);
 
    // Create data.
    $fields[] = "`vendor_id` = '".$vendor_id."'";
    $fields[] = "`product_id` = '".$product['id']."'";
    if (empty($_POST['price']) 
        || !is_numeric($_POST['price']) 
        || $_POST['price'] < 0 
    )
      {
          $fields[] = "`price` = '".$product['price']."'";    
      }
    else
      {
          $fields[] = "`price` = '".$_POST['price']."'";    
      }

    if (empty($_POST['quantity']) 
        || !is_numeric($_POST['quantity']) 
        || $_POST['quantity'] < 1 
    )
      {
          $quantity = 1;    
      }
    else
      {
          $quantity = $_POST['quantity'];    
      }

    $fields[] = "`quantity` = '1'";      
    $fields[] = "`date` = '".date('Y-m-d H:i:s')."'";

    for ($i = 0; $i < $quantity; $i++)
      {
          // Create query; 
          $query = "INSERT INTO `".$config['db_prefix']."vendors_products` SET ". implode(', ',$fields);

          // Insert into the database. 
          $result = @mysql_query($query);
      
          // Verify insertion result.
          if (!$result)
            {
                return _tr("An error occured. The product couldn't be 
                    added to the vendor products list."
                );
            }  
      }

    return ''; 
}

function remove_product($vendor_id, $type = '')
{
    global $config;

    // Verify type variable.
    if ($type == 'returned')
      {
          // Define table for returned prduct.
          $table = 'vendors_products_returned'; 
      }
    else if ($type == 'sold')
      {
          // Define table name for product sold.
          $table = 'vendors_products_sold'; 
      }

    $where_date = "";

    // Verify if date was defined.
    if (isset($_POST['product_date']))
      {
          $where_date = " AND `date` LIKE '%".$_POST['product_date']."%' ";
      }

    // Verify quantity variable.
    if (!isset($_POST['quantity-input']) 
        || !is_numeric($_POST['quantity-input'])
        || $_POST['quantity-input'] < 1
    )
      {   
          $quantity = 1; 
      }
    else
     {
          $quantity = intval($_POST['quantity-input']);
     }

    // Define query to calculate the number of existing products.
    $query = "SELECT COUNT(*) as `number` FROM 
        `".$config['db_prefix']."vendors_products` 
        WHERE `product_id`='".$_POST['product_id']."' 
        AND `vendor_id`='".$vendor_id."' 
        AND `price`='".$_POST['product_price']."'".$where_date;
            
    // Execute query. 
    $result = @mysql_query($query);

    // Verify result.
    if (!$result)
      {
          return;
      }
    
    // Fetch the result.        
    $number = @mysql_fetch_array($result, MYSQL_ASSOC);

    if ($quantity > $number['number'])
      {
          $quantity = $number['number'];
      }

    if ($type != 'delete')
      {
          // Define query to get product data.
          $query = "SELECT * FROM `".$config['db_prefix']."vendors_products` 
              WHERE `product_id`='".$_POST['product_id']."' 
              AND `vendor_id`='".$vendor_id."' 
              AND `price`='".$_POST['product_price']."' 
              ".$where_date." LIMIT 1";

          // Execute query;
          $result = @mysql_query($query);
 
          // Verify result.
          if (!$result)
            {
                return;
            }
    
         // Fetch the result.
         $product = @mysql_fetch_array($result, MYSQL_ASSOC);

         // Create data.
         $fields[] = "`product_id` = '".$product['product_id']."'";
         $fields[] = "`vendor_id` = '".$product['vendor_id']."'";
         $fields[] = "`price` = '".$product['price']."'";
         $fields[] = "`date` = '".date('Y-m-d H:i:s')."'";
         $fields[] = "`user_id` = '".$_SESSION['magsales']['user_id']."'";


        // Insert data.
         for ($i = 0; $i < $quantity; $i++)
         {    
             // Get poduct data
             $query = "INSERT INTO `".$config['db_prefix'].$table."` SET ".implode(", ",$fields); 
             @mysql_query($query);
         }
     } // if($type != 'delete')
 
    $query = "DELETE FROM `".$config['db_prefix']."vendors_products` 
        WHERE `product_id`='".$_POST['product_id']."' 
        AND `vendor_id`='".$vendor_id."' 
        AND `price`='".$_POST['product_price']."' 
        ".$where_date." LIMIT ".$quantity;

    // Delete venor products.
    @mysql_query($query);
}

function delete_product($vendor_id, $table = "sold")
{
    global $config;

    if ($table == "sold")
      {
          $table = "vendors_products_sold";
      }
    else 
      {
          $table = "vendors_products_returned";
      }

    // Verify quantity variable.
    if (!isset($_POST['quantity-input']) 
        || !is_numeric($_POST['quantity-input'])
        || $_POST['quantity-input'] < 1
    )
      {   
          $quantity = 1; 
      }
    else
     {
          $quantity = intval($_POST['quantity-input']);
     }

    $query = "DELETE FROM `".$config['db_prefix'].$table."` 
        WHERE `product_id`='".$_POST['product_id']."' 
        AND `vendor_id`='".$vendor_id."' 
        AND `price`='".$_POST['product_price']."'
        AND `date` LIKE '%".$_POST['product_date']."%' LIMIT ".$quantity;

    // Delete products.
    @mysql_query($query);
}

function get_vendor_products($id, $by_date = FALSE)
{
    global $config;

    if (!$by_date)
      {
          // Define request query.
          $query = "SELECT `id`, `product_id`, `vendor_id`, 
              `price`, SUM(`quantity`) as `quantity`
              FROM `".$config['db_prefix']."vendors_products` 
              WHERE `vendor_id` = '".$id."' 
              GROUP BY `product_id`, `price`";
      }
    else
      { 
          // Define request query.
          $query = "SELECT `id`, `product_id`, `vendor_id`, 
              CAST(`date` AS DATE) as `date`, `price`, SUM(`quantity`) as `quantity`
              FROM `".$config['db_prefix']."vendors_products` 
              WHERE `vendor_id` = '".$id."' 
              GROUP BY CAST(`date` AS DATE), `product_id`, `price`
              ORDER BY `date` DESC";
       }

    // Select vendors.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $vendor_products = array();

    // Fetch the result.
    while ($vendor_product = @mysql_fetch_array($result, MYSQL_ASSOC))
      { 
          // Get the information about the product by its id from 
          // the list of products.
          $product = get_product($vendor_product['product_id']);

          // Add the name of the product. 
          $vendor_product['name'] = $product['name'];
          $vendor_products[] = $vendor_product;
      }

    return $vendor_products;
}

function sold_by_vendors($date_from, $date_to, $vendor_id = '')
{
    global $config;

    if (empty($vendor_id) || !is_numeric($vendor_id))
      {
          $query = "SELECT CAST(`date` AS DATE) as `date`, 
              `vendor_id`, SUM(`quantity`*`price`) as `sum`
              FROM `".$config['db_prefix']."vendors_products_sold`  
              WHERE `date` >= '".$date_from."' 
              AND `date` <= '".$date_to."' GROUP BY CAST(`date` AS DATE), `vendor_id`
              ORDER BY `date` DESC";
      }
    else
      {
          $query = "SELECT CAST(`date` AS DATE) as `date`, 
              `vendor_id`, SUM(`quantity`*`price`) as `sum`
              FROM `".$config['db_prefix']."vendors_products_sold`  
              WHERE `vendor_id` = '".$vendor_id."' AND `date` >= '".$date_from."' 
              AND `date` <= '".$date_to."' GROUP BY CAST(`date` AS DATE), `vendor_id`
              ORDER BY `date` DESC";         
      }

    // Select vendors.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $products_sold = array();

    // Fetch the result.
    while ($product_sold = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          // Get the information about the product by 
          // its id from the list of products.
          $vendor = get_vendor($product_sold['vendor_id']);
          
          // Add the name of the product. 
          $product_sold['name'] = $vendor['name'];
          $products_sold[] = $product_sold;
      }

    return $products_sold;
    
}

function get_vendors_sold_products($date_from, $date_to, $vendor_id = '')
{
    global $config;

    // Verify vendor id valibale.
    if (empty($vendor_id) || !is_numeric($vendor_id))
      {
          // Prepare query to get vendor sold products. 
          $query = "SELECT `id`, `product_id`, `vendor_id`,
              `price`, SUM(`quantity`) as `quantity`, CAST(`date` AS DATE) as `date`
              FROM `".$config['db_prefix']."vendors_products_sold`  
              WHERE `date` >= '".$date_from."' 
              AND `date` <= '".$date_to."' GROUP BY `price`, `product_id`, CAST(`date` AS DATE) 
              ORDER BY `date` DESC"; 
      }
    else
     {
          // Prepare query to get vendor sold products. 
          $query = "SELECT `id`, `product_id`, `vendor_id`,
              `price`, SUM(`quantity`) as `quantity`, CAST(`date` AS DATE) as `date`
              FROM `".$config['db_prefix']."vendors_products_sold`  
              WHERE `vendor_id` = '".$vendor_id."' AND `date` >= '".$date_from."' 
              AND `date` <= '".$date_to."' GROUP BY `price`, `product_id`, CAST(`date` AS DATE) 
              ORDER BY `date` DESC";
     }

    // Select vendors.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $products_sold = array();

    // Fetch the result.
    while ($product_sold = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          // Get the information about the product by 
          // its id from the list of products.
          $product = get_product($product_sold['product_id']);
          
          // Add the name of the product. 
          $product_sold['name'] = $product['name'];
          $products_sold[] = $product_sold;
      }

    return $products_sold;
}

function get_vendors_returned_products($date_from, $date_to, $vendor_id = '')
{
    global $config;

    // Verify vendor id valibale.
    if (empty($vendor_id) || !is_numeric($vendor_id))
      {
          // Prepare query to get vendor sold products. 
          $query = "SELECT `id`, `product_id`, `vendor_id`,
              `price`, SUM(`quantity`) as `quantity`, CAST(`date` AS DATE) as `date`
              FROM `".$config['db_prefix']."vendors_products_returned`  
              WHERE `date` >= '".$date_from."' 
              AND `date` <= '".$date_to."' GROUP BY `price`, `product_id`, CAST(`date` AS DATE) 
              ORDER BY `date` DESC"; 
      }
    else
     {
          // Prepare query to get vendor sold products. 
          $query = "SELECT `id`, `product_id`, `vendor_id`,
              `price`, SUM(`quantity`) as `quantity`, CAST(`date` AS DATE) as `date`
              FROM `".$config['db_prefix']."vendors_products_returned`  
              WHERE `vendor_id` = '".$vendor_id."' AND `date` >= '".$date_from."' 
              AND `date` <= '".$date_to."' GROUP BY `price`, `product_id`, CAST(`date` AS DATE) 
              ORDER BY `date` DESC";
     }

    // Select vendors.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $products_returned = array();

    // Fetch the result.
    while ($product_returned = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          // Get the information about the product by 
          // its id from the list of products.
          $product = get_product($product_returned['product_id']);
          
          // Add the name of the product. 
          $product_returned['name'] = $product['name'];
          $products_returned[] = $product_returned;
      }

    return $products_returned;
}

function vendor_products_total($id)
{
    global $config;

    // Define request query.
    $query = "SELECT SUM(`quantity` * `price`) as `total` 
        FROM `".$config['db_prefix']."vendors_products` 
        WHERE `vendor_id` = '".$id."'";

    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

   $total = @mysql_fetch_array($result, MYSQL_ASSOC);

   // Verify the sum.
   if (empty($total['total']))
     {
         return 0;
     }

    return $total['total'];
}

function archive_vendor($id, $archived = FALSE)
{    
    global $config;

    // Verify id variable
    if (!isset($id) || !is_numeric($id))
      {
          return FALSE;
      }

    // Prepare query for product update.
    $query = "UPDATE `".$config['db_prefix']."vendors` 
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
