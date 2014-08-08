<?php

/**
 * File name: lib.statistics.php
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

function mags_sales_by_products($args = array())
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

    if (!empty($args['user']))
      {
          $conditions[] = "s.user_id = " . $args['user'];
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

    $sql = "SELECT c.id, c.name, (SUM(s.quantity) / (SELECT SUM(s1.quantity)
        FROM ".$config['db_prefix']."sales s1 "
        . str_replace("s.", "s1.", $where) .")) * 100 as percent, 
        SUM(s.quantity) as quantity, SUM(s.quantity*s.price) as totprice
        FROM ".$config['db_prefix']."sales s
        LEFT JOIN ". $config['db_prefix']. "categories c ON s.product_id = c.id
        " . $where . " GROUP BY s.product_id ORDER BY percent DESC";

   $result = @mysql_query($sql);

   if (!$result)
     {
         return array();
     }

    $stats = array();
    while ($value = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $stats[] = $value;
      }

    return $stats;
}

function mags_product_sales_by_price($product_id, $args = array())
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

    if (!empty($args['user']))
      {
          $conditions[] = "s.user_id = " . $args['user'];
      }

    if (!empty($args['magasine']))
      {
          $conditions[] = "s.magazine_id = " . $args['magazine'];
      }

    $where = " WHERE s.product_id ='" . $product_id ."' ";

    if (!empty($conditions))
      {
          $where .= " AND " . implode(" AND ", $conditions) . " ";
      }

    $sql = "SELECT s.price, (SUM(s.quantity) / (SELECT SUM(s1.quantity)
        FROM ".$config['db_prefix']."sales s1"
        . str_replace("s.", "s1.", $where) .")) * 100 as percent,
        SUM(s.quantity) as quantity, SUM(s.quantity*s.price) as totprice
        FROM ".$config['db_prefix']."sales s
        " . $where . " GROUP BY s.price ORDER BY percent DESC";

   $result = @mysql_query($sql);

   if (!$result)
     {
         return array();
     }

    $stats = array();
    while ($value = @mysql_fetch_array($result, MYSQL_ASSOC))
      {
          $stats[] = $value;
      }

    return $stats;
}

function get_quantity_by_month($product_id, $month)
{
    global $config;

    $sql = "SELECT SUM(quantity) as quantity FROM mag_sales WHERE date LIKE '%". $month ."%' AND product_id = " . $product_id;

   $result = @mysql_query($sql);

   if (!$result)
     {
         return array();
     }

   $value = @mysql_fetch_array($result, MYSQL_ASSOC);


    return $value['quantity'];
}
