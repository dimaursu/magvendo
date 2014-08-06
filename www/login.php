<?php

error_reporting(-1);
ini_set('display_errors', '1');

// Require configuration file.
require_once 'configure.php';

// Start session.
session_start();

// Verify login.
if (isset($_SESSION['login']))
  {
      header('Location: index.php');
  }

require_once 'languages/'.LSLANG.'.php';

// Require general functions file.
require_once 'includes/functions.php';
// Require magazines library.
require_once 'includes/lib.magazines.php';
// require workes library.
require_once 'includes/lib.workers.php';

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

    die();
}

// Set names UTF8.
if (!@mysql_query('SET names utf8'))
{
    // Set the database error variable.
    echo "Database error (set names): " . mysql_error(); 

    die();
}


// Verify if login was submitted.
if (isset($_POST['login']))
  {
      $login_error = login();
  }

function login()
{
    global $config;

    // Verify both user and password were set.
    if (empty($_POST['user']) || empty($_POST['password']))
      {
          return _tr('User or password is not correct.');
      }

    // Select the user from the database.
    $query = "SELECT * FROM `".$config['db_prefix']."users` 
    WHERE `username` = '".real_escape($_POST['user'])."' LIMIT 1";
           
    // Select contact.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return _tr('User or password is not correct.');
     }  

    // Fetch the result.
    $user = @mysql_fetch_array($result, MYSQL_ASSOC);

    // Verfy password.
    if (md5($_POST['password']) != $user['password'])
      {
          return _tr('User or password is not correct.');    
      }
    else
     {
         // Store session data.
         $_SESSION['magsales']['login'] =  true;
         $_SESSION['magsales']['user_id'] =  $user['id'];
         $_SESSION['magsales']['user_role'] = $user['role'];
         $_SESSION['magsales']['magazine_id'] = $_POST['magazine'];
       
         // Verify magazine.
         if (has_magazine($_POST['magazine']))   
           {
               @mysqli_close($db_link);
               header('Location: index.php');
           }
        else
          {
              unset($_SESSION['magsales']);
              return _tr('The magazine is not corect'); 
          }  
     }
}

?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="UTF-8" />
    <title>LightStore - Login</title>
    <link rel='stylesheet' href='css/login-page.css' type='text/css' media='all' />
</head>

<body>

<h1 id="header"><a href="index.php">Light Store</a></h1>

<form id="login-form" enctype="multipart/form-data" action="login.php" method="post">
<?php if (!empty($login_error)) :?>
    <p class="error"><?php echo $login_error; ?></p>
<?php endif; ?>
<p>
  <label><?php _e('Magazine'); ?></label> <br>
  <?php $magazines = get_magazines(); ?>
  <select type="text" name="magazine" />
    <?php foreach ($magazines as $magazine) : ?>
        <option value="<?php echo $magazine['id']; ?>"><?php echo $magazine['name']; ?></option>
    <?php endforeach; ?>
  </select>
</p>
<p><label><?php _e('User'); ?></label> <br/ ><input type="text" name="user" autofocus="autofocus" /></p>
<p><label><?php _e('Password'); ?></label> <br /> <input type="password" name="password" /></p>
<p><input class="login-submit" type="submit" name="login" value="<?php _e('Login'); ?>" /></p>
</form>

<p id="footer"><b><a href="http://sv-ti.com/light-store">Light Store</a></b> - <?php _e('a <a href="https://www.gnu.org/philosophy/free-sw.html">free software</a> web application for store management.'); ?></p>

</body>
</html>

<?php @mysqli_close($db_link); ?>
