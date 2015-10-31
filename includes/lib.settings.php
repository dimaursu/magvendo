<?php

/**
 * File name: lib.settings.php
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


function get_settings($name)
{
    global $config;

    // Define SQl request query.
    $query = "SELECT * FROM `".$config['db_prefix']."settings` 
    WHERE `name` = '".$name."'";
           
    // Select contact.
    $result = @mysql_query($query); 

    // Verify the selection result.
    if (!$result)
     {
         return '';
     }  

    // Fetch the result.
    $settings = @mysql_fetch_array($result, MYSQL_ASSOC);

    return $settings['value'];
}

function save_settings($name, $value)
{
    global $config;

    // Prepare query for user update.
    $query = "UPDATE `".$config['db_prefix']."settings` 
        SET `value` = '".$value."' WHERE `name` = '".$name."'";

    @mysql_query($query);
}
