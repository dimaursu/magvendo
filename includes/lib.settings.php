<?php

/**
 * File name: lib.settings.php
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


function mag_get_settings($name)
{
    global $config;

    $query = "SELECT * FROM `" . $config['db_prefix'] . "settings` 
    WHERE `name` = '" . $name . "'";
           
    $result = @mysql_query($query); 

    if (!$result) {
        return NULL;
    }  

    $settings = @mysql_fetch_array($result, MYSQL_ASSOC);

    if (!isset($settings['value'])) {
        return NULL;
    }

    return $settings['value'];
}

function mag_save_settings($name, $value)
{
    global $config;

    if (mag_settings_exists($name)) {
        $query = "UPDATE `" . $config['db_prefix'] . "settings` 
            SET `value` = '" . $value . "' WHERE `name` = '" . $name . "'";
    } else {
        $query = "INSERT INTO `" . $config['db_prefix'] . "settings` 
            (`name`, `value`) VALUES ('" . $name . "', '" . $value . "')";
    }

    @mysql_query($query);
}


function mag_settings_exists($name) {
    global $config;

    $sql = "SELECT `id` FROM `" . $config['db_prefix'] . "settings`
        WHERE `name` = '" . $name . "' LIMIT 1";

    $result = @mysql_query($sql);

    if (!$result) {
        return FALSE;
    }

    $number = mysql_num_rows($result);

    if ($number === FALSE) {
        return FALSE;
    }

    if ($number > 0) {
        return TRUE;
    }

    return FALSE;
}
