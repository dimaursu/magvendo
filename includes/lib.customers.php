<?php

/**
 * File name: lib.customers.php
 * Copyright (C) 2015 Iurie Nistor (http://sv-ti.com)
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

function mag_get_customer($id)
{
    global $config;

    if (!is_numeric($id)) {
          return array();
    }

    $query = "SELECT * FROM `" . $config['db_prefix'] . "customers` 
    WHERE `id` = '" . $id . "'";
           
    $result = @mysql_query($query); 

    if (!$result) {
        return array();
    }  

    $customer = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $customer;
}

function mag_get_customers($page = '', $args = array(), $items_per_page = 20)
{
    global $config;

    $limit = '';

    if (!empty($page) && is_numeric($page) && $page > 0) {
        $limit = " LIMIT " . ($page-1) * $items_per_page . ", " . $items_per_page;
    }

    // Verify search variable.
    if (!empty($args['search'])) {
        $conditions[] = "(c.card = '" . $args['search'] . "' 
              OR c.name LIKE '%" . $args['search'] . "%' 
              OR c.phone LIKE '%" . $args['search'] . "%')";
    }

    if (empty($conditions)) {
        $conditions = '';
    } else {
        $conditions = " WHERE " . implode(" AND ", $conditions);
    }  

    $query = "SELECT c.id, c.card, c.name, c.phone, c.birthday,
        ROUND(SUM(s.price * (1 - s.discount/100) * s.quantity), 2)
        as sales FROM " . $config['db_prefix'] . "customers c
        LEFT JOIN " . $config['db_prefix'] . "sales s 
        ON c.card = s.card_number "
        . $conditions . " GROUP BY c.card 
        ORDER BY sales DESC " . $limit;

    $result = @mysql_query($query); 

    if (!$result) {
       return array();
    }  

    $customers = array();
    while ($customer = @mysql_fetch_array($result, MYSQL_ASSOC)) {
        $customers[] = $customer;
    }

    return $customers;
}

function mag_customers_number($args = array())
{
    global $config;

    if (!empty($args['search'])) {
        $conditions[] = "(`card` = '" . $args['search'] . "' 
            OR `name` LIKE '%" . $args['search'] . "%' 
            OR `phone` LIKE '%" . $args['search'] . "%')";
    }

    if (empty($conditions)) {
        $conditions = '';
    } else {
        $conditions = " WHERE " . implode(" AND ", $conditions);
    }  

    $query = "SELECT COUNT(*) as `number` 
        FROM `" . $config['db_prefix'] . "customers` " . $conditions;

    $result = @mysql_query($query); 

    if (!$result) {
       return 0;
    }

    $number = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $number['number'];
}

/**
 * Save customer function.
 *
 * Adds a new customer or updates an existing one.
 *
 * @return
 *   Returns a string contaning the error, othewise an empty string.
 */
function mag_save_customer()
{
    global $config;

    $update = FALSE;
    if (isset($_GET['id'])) {
        $update = TRUE;
    }

    if (user_role() != ADMIN_ROLE) {
        return _tr('Not enought rights to perform this operation');
    }

    if (empty($_POST['name'])) {
        return _tr("Name field is empty.");
    }

    $fields[] = "`name` = '" . $_POST['name'] . "'";
    if (!empty($_POST['phone'])) {
        $fields[] = "`phone` = '" . $_POST['phone'] . "'";
    }
    if (!empty($_POST['email'])) {
        $fields[] = "`email` = '" . $_POST['email'] . "'";
    }
    if (!empty($_POST['birthday'])) {
        $fields[] = "`birthday` = '" . date("Y-m-d", strtotime($_POST['birthday'])) . "'";
    }

    if (!$update) {
        $query = "INSERT INTO `" . $config['db_prefix'] . "customers` 
            SET ". implode(', ', $fields);
    } else {
         $query = "UPDATE `" . $config['db_prefix'] . "customers` 
             SET ". implode(', ', $fields) . " WHERE `id` = '" . $_GET['id'] . "'";
    }

    $result = @mysql_query($query);

    if (!$result) {
        return _tr("An error occured. The customer was not saved.");
    }

    return '';
}

function mag_remove_customer($id)
{
    global $config;

    $query = "DELETE FROM `" . $config['db_prefix'] . "customers`
        WHERE `id` = '" . $id . "'";

    // Maybe to remove also the info about
    // the card (for the future).

    @mysql_query($query);
}
