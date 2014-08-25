<?php

/**
 * File name: lib.workers.php
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

// Define workers roles.
define("SALE", 1);
define("REPARE", 2);
define("FABRICATE", 3);

// Define the array of string of worker roles.
$work_roles = array( 
    SALE      => _tr('Sale role'), 
    REPARE    => _tr('Repare role'), 
    FABRICATE => _tr('Fabricate role')
);

// Define the array for pages url by worker roles.
$work_roles_page_url = array( 
    SALE      => 'sales', 
    REPARE    => 'repared-list', 
    FABRICATE => 'fabricated-list'
);

function mags_get_worker($id)
{
    global $config;

    $sql = "SELECT u.* FROM " . $config['db_prefix'] . "users u
        WHERE u.id = " . $id . " AND u.id IN (SELECT w.user_id FROM mag_workers w)";

    $result = @mysql_query($sql);

    if (!$result)
      {
          return array();
      }

    $worker = @mysql_fetch_array($result, MYSQL_ASSOC);

    if (empty($worker))
      {
          return array();
      }

    return $worker;
}

/**
 * Get workers function.
 *
 * Get the list of workers by magazine id.
 *
 * @param $magazine_id
 *   Magazine id.
 *
 *
 * @return
 *   An array of workes data.
 */
function get_workers($magazine_id = '')
{
    return get_workes($magazine_id);
}
function get_workes($magazine_id = '')
{
    global $config;

    $where = "";
    if (!empty($magazine_id))
      {
          $where = " WHERE w.magazine_id = " . $magazine_id;
      }

    $query = "SELECT * FROM ".$config['db_prefix']."users u
         WHERE u.id IN (SELECT w.user_id FROM " . $config['db_prefix'] . "workers w
         " . $where .")";

    $result = @mysql_query($query);

   if (!$result)
     {
         return array();
     }

    $users = array();

    while ($user = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $users[] = $user;
      }

    return $users;
}

/**
 * Get worker magazines function.
 *
 * Get the list of magazines of a worker by user id.
 *
 * @param $id
 *   User id of a worker.
 *
 * @return
 *   And array containing the list of worker magazines.
 */
function get_worker_magazines($id)
{
    global $config;

    $workers_tb = $config['db_prefix']."workers";
    $magazines_tb = $config['db_prefix']."magazines";

    // Prepare query.
    $query = "SELECT ".$magazines_tb.".id, ".$magazines_tb.".name 
         FROM ".$magazines_tb." INNER JOIN ".$workers_tb." 
         ON ".$magazines_tb.".id = ".$workers_tb.".magazine_id 
         WHERE ".$workers_tb.".user_id = ".$id;

   // Select magazines ids.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $magazines = array();

    // Fetch the result.
    while ($magazine = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $magazines[] = $magazine;
      }

    return $magazines;
}

/**
 * Has worker role function.
 * 
 * Determines if a workes have a particular role.
 *
 * @param $role
 *   The worker role.
 *
 * @return
 *   Return TRUE if workes has a such role, otherwise FALSE.
 */
function has_worker_role($role, $user_id = '', $magazine_id = '')
{
    global $config;

    if (empty($magazine_id))
      {
          $magazine_id = $_SESSION['magsales']['magazine_id'];
      }

    if (empty($user_id))
      {
          $user_id = $_SESSION['magsales']['user_id'];
      }
     

    $query = "SELECT COUNT(*) as `number` FROM `".$config['db_prefix']."workers` 
        WHERE `user_id` = '".$user_id."' AND `work_role` = '".$role."' 
        AND `magazine_id` = '".$magazine_id."'";
 
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

/**
 * Has worker role function.
 * 
 * Determines if a workes have a particular role no matter in what magazine.
 *
 * @param $role
 *   The worker role.
 *
 * @return
 *   Return TRUE if workes has a such role, otherwise FALSE.
 */
function has_worker_role_all($role, $user_id = '')
{
    global $config;

    $query = "SELECT COUNT(*) as `number` FROM `".$config['db_prefix']."workers` 
        WHERE `user_id` = '".$user_id."' AND `work_role` = '".$role."'";
 
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


/**
 * Has magazine function.
 * 
 * Determines if a workes is registered in one magazine.
 *
 * @param $role
 *   The magazine id.
 *
 * @return
 *   Return TRUE if workes is registered in the magazine, otherwise FALSE.
 */
function has_magazine($id)
{
    global $config;

    $query = "SELECT COUNT(*) as `number` FROM `".$config['db_prefix']."workers` 
        WHERE `user_id` = '".$_SESSION['magsales']['user_id']."' AND `magazine_id` = '".$id."'";
 
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

function worker_has_magazine($worker_id, $magazine_id)
{
    global $config;

    $query = "SELECT COUNT(*) as `number` FROM `".$config['db_prefix']."workers` 
        WHERE `user_id` = '".$worker_id."' AND `magazine_id` = '".$magazine_id."'";
 
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




/**
 * Get worker roles.
 * 
 * Gets all roles of a worker magazine and user id. 
 *
 * @param $user_id
 *   The worker user id.
 *
 * @param $magazine_id
 *   The id of magazine in which the worker is registered.
 *
 * @return
 *   Returns an array of workers roles, otherwise an empty role.
 */
function get_worker_roles($user_id, $magazine_id)
{
    global $config; 

    // Prepare query.
    $query = "SELECT `work_role` FROM `".$config['db_prefix']."workers` 
        WHERE `user_id` = '".$user_id."' AND `magazine_id` = '".$magazine_id."' 
        ORDER by `work_role`";

   // Select worker roles.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         // Return an empty array;
         return array();
     }  

    $roles = array();

    // Fetch the result.
    while ($role = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $roles[] = $role;
      }

    return $roles;   
}

/**
 * Worked days funciton.
 *
 * Get the number of worked days (of the current months) of 
 * a worker by worker's user id and magazine id.
 *
 * @param $user_id
 *   Workers's user id.
 * 
 * @param $magazine_id
 *   The of the magazine in which the worker is registered.
 *
 * @return
 *   Returns a number of worked days.
 */
function worked_days($user_id, $magazine_id, $date_from, $date_to)
{
    global $config;

    $query = "SELECT COUNT(d) as days FROM (SELECT d FROM
        (SELECT id, CAST(`date` AS DATE) as d FROM 
        `".$config['db_prefix']."sales` WHERE `user_id` = '".$user_id."' 
        AND `magazine_id` = '".$magazine_id."' 
        AND CAST(`date` AS DATE) >= '".$date_from."' 
        AND CAST(`date` AS DATE) <= '".$date_to."'
        UNION
        SELECT id, CAST(`date` AS DATE) as d FROM
        `".$config['db_prefix']."repared` WHERE `user_id` = '".$user_id."' 
        AND `magazine_id` = '".$magazine_id."' 
        AND CAST(`date` AS DATE) >= '".$date_from."' 
        AND CAST(`date` AS DATE) <= '".$date_to."'
        UNION  
        SELECT id, CAST(`date` AS DATE) as d FROM 
        `".$config['db_prefix']."fabricated` WHERE `user_id` = '".$user_id."' 
        AND `magazine_id` = '".$magazine_id."' 
        AND CAST(`date` AS DATE) >= '".$date_from."' 
        AND CAST(`date` AS DATE) <= '".$date_to."') a GROUP BY d) b"; 

    $result = @mysql_query($query);

    if (!$result)
      {
          return 0;
      }

    $number = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $number['days'];
}

/**
 * Get worker salary function.
 *
 * Gets the worker's sallary for a period by in a magazine and worker's user id.
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
 * @param $user_id
 *   Worker's user id.
 *
 * @return
 *   Returns and array contaning the sallaries for all roles, and the total sallary.
 *
 */
function get_worker_salary($date_from, $date_to, $magazine_id, $user_id)
{
    global $config;
  
    $salary = array(); 
    $sale_salary = 0;
    $repared_salary = 0;
    $as_repared_role = 0;
    $fabricated_salary = 0;

    // Calculate all sales sum int the magazine.
    $sales_sum = sales_sum($date_from, $date_to, $magazine_id); 

    // Check if worker has SALE role.
    if (has_worker_role(SALE, $user_id, $magazine_id))
      {
          $sale_salary = worker_sales_salary(
              $date_from, $date_to, $magazine_id, $user_id
          );

         $salary['sale'] = floor($sale_salary);

      }

    // Check if worker has repared role.
    if (has_worker_role(REPARE, $user_id, $magazine_id))
      {
           
          $repared_salary = worker_repared_salary(
              $date_from, $date_to, $magazine_id, $user_id
          );

          $salary['repared'] = floor($repared_salary);
	  /*          $as_repared_role = 0.05 * $sales_sum;*/
          $args = array(
	      'from' => $date_from,
              'to' => $date_to,
              'magazine' => $magazine_id
          );
          $salary['repared_sales_percent'] = floor(worker_sales_salary_for_repare($args));
      }


    // Check if worker has fabricate role.
    if (has_worker_role(FABRICATE, $user_id, $magazine_id))
      {
           
          $fabricate_salary = worker_fabricated_salary(
              $date_from, $date_to, $magazine_id, $user_id
          );
	  $salary['fabricated'] = round($fabricate_salary, 2, PHP_ROUND_HALF_DOWN);
      }

    $salary['total_salary'] = 0;
    if(isset($salary['sale'])) $salary['total_salary'] += $salary['sale'];
    if(isset($salary['repared'])) $salary['total_salary'] += $salary['repared'];
    if(isset($salary['repared_sales_percent'])) 
        $salary['total_salary'] += $salary['repared_sales_percent'];
    if(isset($salary['fabricated'])) 
        $salary['total_salary'] += $salary['fabricated'];

    return $salary;

}


function worker_sales_salary($date_from, $date_to, $magazine_id, $user_id)
{

    global $config;

    // Prepare query to get the user sales. 
    $query = "SELECT `price`, `quantity`, `discount`, 
        CAST(`date` AS DATE) as `date`, salary_percent 
        FROM `".$config['db_prefix']."sales`  
        WHERE CAST(`date` AS DATE) >= '".$date_from."'
        AND CAST(`date` AS DATE) <= '".$date_to."'
        AND `magazine_id` = '".$magazine_id."' AND `user_id` = '".$user_id."'";  

    // Select sales.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         return 0;
     }  

    $salary = 0;

    // Fetch the result.
    while ($sale = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $salary_percent =
              !$sale['salary_percent'] ? 0.1 : 0.01 * $sale['salary_percent'];

          $salary += floor($sale['quantity'] *
              $sale['price'] *
              (1 - 0.01 * $sale['discount']) * $salary_percent);
      }

    return $salary;
}


function worker_repared_salary($date_from, $date_to, $magazine_id, $user_id)
{

    global $config;

    // Prepare query to get the user sales. 
    $query = "SELECT `price`, `quantity`, `salary_percent`, 
        CAST(`date` AS DATE) as `date` FROM `".$config['db_prefix']."repared`  
        WHERE CAST(`date` AS DATE) >= '".$date_from."'
        AND CAST(`date` AS DATE) <= '".$date_to."'
        AND `magazine_id` = '".$magazine_id."' AND `user_id` = '".$user_id."'"; 

    // Select.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         return 0;
     }  

    $sum = 0;

    // Fetch the result.
    while ($repared = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $sum += $repared['quantity'] 
              *$repared['price']*0.01*$repared['salary_percent'];
      }

    return $sum;
}

function worker_sales_salary_for_repare($args = array())
{

    global $config;

    if (!empty($args['from']))
      {
          $conditions[] = "CAST(s.date AS DATE) >= '" . $args['from'] . "'";
      }

    if (!empty($args['to']))
      {
          $conditions[] = "CAST(s.date AS DATE) <= '" . $args['to'] . "'";
      }

    if (!empty($args['worker']))
      {
          $conditions[] = "s.user_id = " . $args['worker'];
      }

    if (!empty($args['magazine']))
      {
          $conditions[] = "s.magazine_id = " . $args['magazine'];
      }

    $where = "";

    if (!empty($conditions))
      {
          $where = " WHERE " . implode(" AND ", $conditions);
      }

    $query = "SELECT SUM((s.quantity * s.price * (1 - 0.01 * s.discount))
             * (IFNULL(pp.repare_percent, 5) / 100)) as salary
        FROM ".$config['db_prefix']."sales s
        LEFT JOIN ".$config['db_prefix']."products_percents pp
        ON s.product_id = pp.product_id " . $where;

    $result = @mysql_query($query);
    if (!$result)
      {
          return 0;
      }

    $value = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $value['salary'];
}


function worker_fabricated_salary($date_from, $date_to, $magazine_id, $user_id)
{

    global $config;

    // Prepare query to get the user sales. 
    $query = "SELECT `quantity`, `salary`, 
        CAST(`date` AS DATE) as `date` FROM `".$config['db_prefix']."fabricated`  
        WHERE CAST(`date` AS DATE) >= '".$date_from."'
        AND CAST(`date` AS DATE) <= '".$date_to."'
        AND `magazine_id` = '".$magazine_id."' AND `user_id` = '".$user_id."'"; 

    // Select.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         return 0;
     }  

    $sum = 0;

    // Fetch the result.
    while ($fabricated = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $sum += $fabricated['quantity']*$fabricated['salary'];
      }

    return $sum;
}

function get_sum_by_date($date, $magazine_id)
{
    global $config;

    $query = "SELECT SUM(`price` * `quantity` * (1-`discount`*0.01)) as `sum`, `user_id`
        FROM `".$config['db_prefix']."sales`  
        WHERE CAST(`date` AS DATE) = '".$date."'
        AND `magazine_id` = '".$magazine_id."'";

    // Select.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         return 0;
     }  

    // Fetch the result.
    $sales = @mysql_fetch_array($result, MYSQL_ASSOC);

    $sum['sales_sum'] = $sales['sum'];
    $sum['user_id'] = $sales['user_id'];

    $query = "SELECT SUM(`price` * `quantity`) as `sum`
        FROM `".$config['db_prefix']."repared`  
        WHERE CAST(`date` AS DATE) = '".$date."'
        AND `magazine_id` = '".$magazine_id."'";

    // Select.
    $result = @mysql_query($query); 

   // Verify selection result.
   if (!$result)
     {
         return 0;
     }  

    // Fetch the result.
    $repared = @mysql_fetch_array($result, MYSQL_ASSOC);

    $sum['repared_sum'] = $repared['sum'];

    return $sum;
}

function mags_update_worker_roles()
{
    if (empty($_POST['magazine']) || !is_numeric($_POST['magazine']))
      {
          return _tr('Magazine id is not correct.');
      }

    if (!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
          return _tr('Worker id is not correct');
      }

    $error = 0; print_r($_POST);

    if (!empty($_POST['sell']))
      {
          $error = mags_add_role($_GET['id'], $_POST['magazine'], SALE);
      }
    else
      {
          $error = mags_remove_role($_GET['id'], $_POST['magazine'], SALE);
      }

    if (!empty($_POST['repare']))
      {
          $error = mags_add_role($_GET['id'], $_POST['magazine'], REPARE);
      }
    else
      {
          $error = mags_remove_role($_GET['id'], $_POST['magazine'], REPARE);
      }

    if (!empty($_POST['fabricate']))
      {
          $error = mags_add_role($_GET['id'], $_POST['magazine'], FABRICATE);
      }
    else
      {
          $error = mags_remove_role($_GET['id'], $_POST['magazine'], FABRICATE);
      }

    if ($error)
      {
          return _tr("Can't update worker roles");
      }

    return "";
}


function mags_add_role($worker, $magazine, $role)
{
    global $config;

    if (has_worker_role($role, $worker, $magazine))
      {
          return 0;
      }

    $sql = "INSERT INTO ".$config['db_prefix']."workers
            (user_id, magazine_id, work_role)
            values(" . $worker . ", " . $magazine  . ", " . $role  . ")";

    $result = @mysql_query($sql);

    if (!$result)
      {
          return 1;
      }

    return 0;
}

function mags_remove_role($worker, $magazine, $role)
{
    global $config;

    if (!has_worker_role($role, $worker, $magazine))
      {
          return 0;
      }

    $sql = "DELETE FROM " . $config['db_prefix'] . "workers
        WHERE user_id = " . $worker . "
        AND magazine_id = " . $magazine . "
        AND work_role = " . $role;

    $result = @mysql_query($sql);

    if (!$result)
      {
          return 1;
      }

    return 0;
}