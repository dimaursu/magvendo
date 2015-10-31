 <?php

/**
 * File name: index.php
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

define("MAGVENDO", TRUE);
define("MAGSALES", TRUE); // For compatibility.
define("MAGV_VERSION_MAJOR", 0);
define("MAGV_VERSION_MINOR", 9);
define("MAGV_VERSION_PATCH", 0);
define("MAGV_APP_NAME", "MagVendo");

require_once 'configure.php';

session_start();

// Verify login.
if (!isset($_SESSION['magsales']['login'])) {
    header('Location: login.php');
    exit;
}

require_once 'languages/'.LSLANG.'.php';

// Require general functions file.
require_once 'includes/functions.php';

// Require libraries.
require_once 'includes/lib.settings.php';
require_once 'includes/lib.magazines.php';
require_once 'includes/lib.sales.php';
require_once 'includes/lib.reparation.php';
require_once 'includes/lib.fabrication.php';
require_once 'includes/lib.users.php';
require_once 'includes/lib.workers.php';
require_once 'includes/lib.vendors.php';
require_once 'includes/lib.products.php';
require_once 'includes/lib.categories.php';
require_once 'includes/lib.statistics.php';
require_once 'includes/lib.customers.php';
require_once 'includes/lib.cards.php';

// Connect to the database.
$db_link = @mysql_connect(
            $config['hostname'], 
            $config['db_username'], 
            $config['db_password']
);

// Verify the database connection.
if (!$db_link)
  {
      // Print the database eroor.
      echo "Database connection error: " . mysql_error(); 

      die();
}

// Select the database. 
if (!@mysql_select_db($config['database'])) 
{
    // Print the database error.
    echo "Database selection error: " . mysql_error();

    // Disconnect from the database.
    @mysqli_close($db_link);
    die();
}

// Set names UTF8.
if (!@mysql_query('SET names utf8'))
{
    // Set the database error variable.
    echo "Database error (set names): " . mysql_error(); 

    // Disconnect from the database.
    @mysqli_close($db_link);

    die();
}

// Verify logout variable.
if (isset($_GET['a']) && $_GET['a'] == 'logout')
  {
      // Remove session data.
      unset($_SESSION['magsales']);
      @mysqli_close($db_link);

      // Redirect to login page.
      header('Location: login.php');
      exit;
  }

// Verify settings.
if (isset($_POST['save_settings']))
{
    if (isset($_POST['main_menu']))
      {
          save_settings("show_menu", 1);
      }
    else
      {
          save_settings("show_menu", 0);
      }
}

// Require theme functions.
require_once 'theme_functions.php';

// Require header.
require_once 'header.php';

if (empty($_GET['p'])) {
    // Require home page.
    require_once 'page-home.php';
} else {
     $restricted = array(
         'magazines',
         'statistics',
         'workers-list',
         'sales-all',
         'categories',
         'add-category',
         'edit-category',
         'stats-price',
         'add-magazine',
         'edit-magazine',
         'sales-by-magazines',
         'edit-worker',
         'add-worker',
         'salaries',
         'add-customer',
         'customer',
         'customers',
         'card-statistics',
         'cards-discount'
     );

     $pagename = $_GET['p'];

     if (user_role() != ADMIN_ROLE && in_array($pagename, $restricted)) {
         $pagename = 'restricted';
     }

     $page = 'page-' . $pagename . ".php";

     // Verify if page exit.
     if (!file_exists($page)) {
         require_once 'nopage.php';
     } else {
         // Require page.
         require_once $page;
     }
 }

// Require footer.
require_once 'footer.php';

// Disconnect from the database.
@mysqli_close($db_link);

?>
