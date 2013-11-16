<?php
require_once '../configure.php';
// Require general functions file.
require_once '../includes/functions.php';

// Require libraries.
require_once '../includes/lib.settings.php';
require_once '../includes/lib.magazines.php';
require_once '../includes/lib.sales.php';
require_once '../includes/lib.reparation.php';
require_once '../includes/lib.fabrication.php';
require_once '../includes/lib.users.php';
require_once '../includes/lib.workers.php';
require_once '../includes/lib.vendors.php';
require_once '../includes/lib.products.php';
require_once '../includes/lib.categories.php';

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


$date_from = date('Y-m-d', mktime(0, 0, 0, date('m') - 10, date("d"),  date("Y")));
$date_to = date('Y-m-d');

$sales = get_sales($date_from, $date_to);

$data = "Магазин, Работник, Товара, Цена, Количество, Скидка, Сумма\n";

foreach ($sales as $sale)
{
    $magazine = get_magazine($sale['magazine_id']);
    $worker   = get_user($sale['user_id']);
    $sum    = ceil($sale['quantity'] * $sale['price'] * (1-0.01*$sale['discount']));

    $data .= $magazine['name'] 
        . ", " . $worker['name'] 
        . ", " . $sale['name'] 
        . ", " . $sale['price'] 
        . ", " . $sale['quantity'] 
        . ", " . $sale['discount'] 
        . ", " . $sum . "\n";            
}

$report_file = "report_" . date('d_m_Y') . ".csv";

file_put_contents($report_file, $data);

send_email($report_file);

function send_email($report_file)
{
    $name = "Oxana Julea";
    $email = "quasar@localhost";
    $to = $name . "<". $email. ">";
    $from = "Отчет Magsales <webmaster@crystal.md>";
    $subject = "Report ...";
    $file_content = file_get_contents($report_file);
    $file_content = chunk_split(base64_encode($file_content));
    $uid = md5(uniqid(time()));

    $header = "From: ". $from ."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= "Report from crystal.md\r\n\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-Type: text/csv; name=\"" . $report_file . "\"\r\n";
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"" . $report_file . "\"\r\n\r\n";
    $header .= $file_content . "\r\n\r\n";
    $header .= "--" . $uid . "--";

    if (!mail($to, $subject, "", $header)) 
      {
          echo "Report have not been sent.\n";
      }
    else
      {
          echo "Report sent.\n";
      }
}
?>
