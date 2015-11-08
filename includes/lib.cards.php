<?php

/**
 * File name: lib.cards.php
 * Copyright (C) 2015 Iurie Nistor (http://sv-ti.com)
 * This file is part of MagSales.
 *
 * MagSales is free software; you can redistribute it and/or modify
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

function mag_card_exists($card)
{
    global $config;

    $sql = "SELECT `id` FROM `" . $config['db_prefix'] . "customers`
        WHERE `card` = '" . $card . "' LIMIT 1";

    $result = @mysql_query($sql);

    if (!$result) {
        return FALSE;
    }

    $number = mysql_num_rows($result);

    if ($number === FALSE) {
        return FALSE;
    }

    return $number;
}

function mag_card_discount($card_number) 
{
    // Now now for all card the discount is the same;
    return mag_get_cards_discount();
}

function mag_cards_sales($from = '', $to = '')
{
    if (!empty($from) && !empty($to)) {
        $sql = "SELECT s.card_number, c.id as customer_id, 
            c.name as customer_name, c.phone, 
            ROUND(SUM(s.price * (1 - s.discount/100) * s.quantity), 2) 
            as sales FROM mag_sales s
            LEFT JOIN mag_customers c ON s.card_number = c.card 
            WHERE CAST(s.date AS DATE) >= '" . $from . "'
            AND CAST(s.date AS DATE) <= '" . $to . "' 
            AND s.card_number IS NOT NULL 
            GROUP BY s.card_number ORDER BY sales DESC";
    } else {
        $sql = "SELECT s.card_number, c.id as customer_id, 
            c.name as customer_name, c.phone, 
            ROUND(SUM(s.price * (1 - s.discount/100) * s.quantity), 2) 
            as sales FROM mag_sales s
            LEFT JOIN mag_customers c ON s.card_number = c.card 
            WHERE s.card_number IS NOT NULL 
            GROUP BY s.card_number ORDER BY sales DESC";
    }

    $result = @mysql_query($sql); 

    if (!$result) { 
        return array();
    }  

    $cards = array();

    while ($card = @mysql_fetch_array($result, MYSQL_ASSOC)) {
        $cards[] = $card;
    }

    return $cards;
}

function mag_card_sales($card_number)
{
    if (!empty($from) && !empty($to)) {
        $sql = "SELECT s.card_number, c.id as customer_id, 
            c.name as customer_name, c.phone, 
            ROUND(SUM(s.price * (1 - s.discount/100) * s.quantity), 2) 
            as sales FROM mag_sales s
            LEFT JOIN mag_customers c ON s.card_number = c.card 
            WHERE CAST(s.date AS DATE) >= '" . $from . "'
            AND CAST(s.date AS DATE) <= '" . $to . "'
            AND c.card = '". $card_number ."'
            AND s.card_number IS NOT NULL 
            GROUP BY s.card_number ORDER BY sales DESC";
    } else {
        $sql = "SELECT s.card_number, c.id as customer_id, 
            c.name as customer_name, c.phone, 
            ROUND(SUM(s.price * (1 - s.discount/100) * s.quantity), 2) 
            as sales FROM mag_sales s
            LEFT JOIN mag_customers c ON s.card_number = c.card 
            WHERE c.card = '". $card_number ."'
            AND s.card_number IS NOT NULL 
            GROUP BY s.card_number ORDER BY sales DESC";
    }

    $result = @mysql_query($sql); 

    if (!$result) { 
        return array();
    }  

    $card = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $card;
}

function mag_set_cards_discount()
{   
    if (!isset($_POST['discount']) || $_POST['discount'] == '') {
        return _tr("Discount must not be empty");
    }

    if (!is_numeric($_POST['discount'])) {
        return _tr("Discount must be numeric");
    }

    if ($_POST['discount'] < 0 || $_POST['discount'] > 100) {
        return _tr("Discount must have values 0 - 100");
    }

    mag_save_settings('cards_discount', intval($_POST['discount']));

    return '';
}

function mag_get_cards_discount()
{
    $discount = mag_get_settings('cards_discount');

    if ($discount == NULL) {
        $discount = 0;
    }

    return $discount;
}

?>