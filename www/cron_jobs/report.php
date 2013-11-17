<?php
require_once 'configure.php';
// Require general functions file.
require_once 'functions.php';

// Require libraries.
require_once 'lib.settings.php';
require_once 'lib.magazines.php';
require_once 'lib.sales.php';
require_once 'lib.reparation.php';
require_once 'lib.fabrication.php';
require_once 'lib.users.php';
require_once 'lib.workers.php';
require_once 'lib.vendors.php';
require_once 'lib.products.php';
require_once 'lib.categories.php';

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


$date_from = date('Y-m-d');
$date_to = date('Y-m-d');

$sales = get_sales($date_from, $date_to);

$data = "Дата,Магазин,Работник,Товара,Цена,Количество,Скидка,Сумма\n";

$total = 0;

foreach ($sales as $sale)
{
    $magazine = get_magazine($sale['magazine_id']);
    $worker   = get_user($sale['user_id']);
    $sum      = ceil($sale['quantity'] * $sale['price'] * (1-0.01*$sale['discount']));

    $data .= date("d-m-Y", strtotime($sale['date']))
        . "," . $magazine['name'] 
        . "," . $worker['name'] 
        . "," . $sale['name'] 
        . "," . $sale['price'] 
        . "," . $sale['quantity'] 
        . "," . $sale['discount'] 
        . "," . $sum . "\n";            

    $total += $sum;
}

$data .= ",,,,,,Итого," . $total . "\n";

$report_sales = "report_sales_" . date('d_m_Y_H_i') . ".csv";

file_put_contents($report_sales, $data);

$date_from = date('Y-m-d', mktime(0, 0, 0, date('m') - 10, date("d"),  date("Y")));
$date_to = date('Y-m-d');  

$magazines = get_magazines(); 

$data = "Дата,Магазин,Продавец,Сумма\n";

for ($date = $date_to; strtotime($date) >= strtotime($date_from); $date = date('Y-m-d', strtotime(' -1 day', strtotime($date))))
{
    
    foreach ($magazines as $magazine)
     {
         $sum_by_date = get_sum_by_date($date, $magazine['id']);

         if (empty($sum_by_date['sales_sum']))
           {
               continue; 
           }
 
         $worker = get_user($sum_by_date['user_id']);
         $data .= date("d-m-Y", strtotime($date)) . "," 
             . $magazine['name'] 
             . "," . $worker['name'] 
             . "," . ceil($sum_by_date['sales_sum']) . "\n";
     }  
}

$report_sums = "report_sums_" . date('d_m_Y_H_i') . ".csv";
file_put_contents($report_sums, $data);

send_email($report_sales, $report_sums);

function send_email($report_sales, $report_sums)
{
    $name = "Oxana Julea";
    $email = "asanagrup@mail.ru";
    $to = $name . "<". $email. ">";
    $from = "MagSales <webmaster@crystal.md>";
    $subject = "Report from MagSales - " . date('d-m-Y H:i');
    $message = "Report from MagSales. See attached CSV file.";
    $file_content_sales = file_get_contents($report_sales);
    $file_content_sales = chunk_split(base64_encode($file_content_sales));
    $file_content_sums = file_get_contents($report_sums);
    $file_content_sums = chunk_split(base64_encode($file_content_sums));
    $uid = md5(uniqid(time()));

    $header = "From: ". $from ."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message . "\r\n\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-Type: text/csv; name=\"" . $report_sales . "\"\r\n";
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"" . $report_sales . "\"\r\n\r\n";
    $header .= $file_content_sales . "\r\n\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-Type: text/csv; name=\"" . $report_sums . "\"\r\n";
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"" . $report_sums . "\"\r\n\r\n";
    $header .= $file_content_sums . "\r\n\r\n";
    $header .= "--" . $uid . "--"; 

    if (!mail($to, $subject, $message, $header)) 
      {
          echo "Report have not been sent.\n";
      }
    else
      {
          echo "Report sent.\n";
      }
}
?>
