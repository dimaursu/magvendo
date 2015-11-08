<?php

/**
 * File name: lib.users.php
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

define("ADMIN_ROLE", 1);


/**
 * Get user function.
 * 
 * Gets a user from the database by its id.
 *
 * @param $id
 *   User id.
 *
 * @return
 *   Return an array contaning user data, otherwise it return an empty array.
 */
function get_user($id)
{
    global $config;

    // Verify user id.
    if (!is_numeric($id))
      {
          return array();
      }

    // Define SQl request query.
    $query = "SELECT * FROM `".$config['db_prefix']."users` 
    WHERE `id` = '".$id."'";
           
    // Select contact.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return array();
     }  

    // Fetch the result.
    $user = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $user;
}

function get_users($page = '', $args = array(), $items_per_page = 10)
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
          $conditions[] = "(`name` LIKE '%".$args['search']."%' 
              OR `username` LIKE '%".$args['search']."%' 
              OR `phone` LIKE '%".$args['search']."%')";
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
    $query = "SELECT * FROM `".$config['db_prefix']."users` ".$conditions."
             ORDER BY `name` ASC".$limit;

    // Select users.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $users = array();

    // Fetch the result.
    while ($user = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $users[] = $user;
      }

    return $users;
}

function users_number($args = array())
{
    global $config;

    // Verify search variable.
    if (!empty($args['search']))
      {
          $conditions[] = "`name` LIKE '%".$args['search']."%'";
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
        FROM `".$config['db_prefix']."users` ".$conditions;

    // Select users.
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
 * Add save user function.
 *
 * Adds a new user or updates an existing one.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function save_user()
{
    global $config;

    // Verify user role.
    if (user_role() != 1) return '';

    // Verify name variable.
    if (empty($_POST['username']))
      {
          return _tr("Username field is empty.");
      }

    // Verify price variable.
    if (empty($_POST['name']))
      {
          return _tr("Name field is empty.");
      }

    // Verify password variable.
    if (!isset($_POST['update']) && empty($_POST['password']))
      {
          return _tr("The password field is empty.");
      }

    // Verify retyped password variable.
    if (!isset($_POST['update']) && empty($_POST['rpassword']))
      {
          return _tr("The retyped password field is empty.");
      }

    // Verify retyped passowrd.
    if (!isset($_POST['update']) && $_POST['password'] != $_POST['rpassword'])
      {
          return _tr("The retyped password is not correct.");
      }

    // Create data array.
    $fields[] = "`username` = '".$_POST['username']."'";
    $fields[] = "`name` = '".$_POST['name']."'";
    if (!empty($_POST['password']))
      {
          $fields[] = "`password` = '".md5($_POST['password'])."'";
      }

    if (!empty($_POST['phone']))
      {
          $fields[] = "`phone` = '".$_POST['phone']."'";
      }

    if (!empty($_POST['email']))
      {
          $fields[] = "`email` = '".$_POST['email']."'";
      }

    if (!empty($_POST['address']))
      {
          $fields[] = "`address` = '".$_POST['address']."'";
      }

    if (!empty($_POST['description']))
      {
          $fields[] = "`description` = '".$_POST['description']."'";
      }

    $archive = empty($_POST['archive']) ? 0 : 1;
    $fields[] = "`status` = '". $archive ."'";

    /*

    $fields[] = "`role` = '".$_POST['role']."'";
    $fields[] = "`registered_date` = '".date('Y-m-d H:i:s')."'";*/

    // Verify user id variable.
    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          // Verify if user exist.
          if (user_exist($_POST['username']))
            {
                return _tr('Such user already exist. Try another username.');
            }
 
          // Prepare query for adding a new user. 
          $query = "INSERT INTO `".$config['db_prefix']."users` 
              SET ". implode(', ',$fields);
      }
    else
     {
         // Prepare query for user update.
         $query = "UPDATE `".$config['db_prefix']."users` 
             SET ". implode(', ',$fields)." WHERE `id` = '".$_GET['id']."'";
     }
    
    // Execute query. 
    $result = @mysql_query($query);

    // Verify insertion result.
    if (!$result)
      {
          return _tr("An error occured. The user was not saved.");
      } 

    return '';
}

function remove_user($id)
{
    global $config;

    // Define query.
    $query = "DELETE FROM `".$config['db_prefix']."users` WHERE `id` = '".$id."'";

    @mysql_query($query);
}

function user_role()
{
    // Verify user seeion role.
    if (!isset($_SESSION['magvendo']['user_role']))
      {
          return 0;
      }

    return $_SESSION['magvendo']['user_role'];
}

function is_role($role)
{
    // Verify session variable.
    if (!isset($_SESSION['magvendo']['user_role']))
      {
          return FALSE; 
      }

    if ($role & user_role()) return TRUE;
    else FALSE;
}

function user_exist($username)
{
    global $config;

    $query = "SELECT COUNT(*) as `number` FROM `".$config['db_prefix']."users` 
        WHERE `username` = '".$username."'";
 
    $result = @mysql_query($query);

    if (!$result)
      {
          return FALSE;
      }

    $number = @mysql_fetch_array($result, MYSQL_ASSOC);

    if ($number['number'] > 0)
      {
          return TRUE;
      }

    return FALSE;
}
