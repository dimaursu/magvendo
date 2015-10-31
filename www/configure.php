<?php

/**
 * File name: configure.php
 * Copyright 2013 Iurie Nistor
 * This file is part of Magsales.
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

$config = array();

// Database information.
$config['hostname'] = 'localhost';
$config['database'] = 'magvendo';
$config['db_username'] = 'root';
$config['db_password'] = 'cactus';
$config['db_prefix'] = 'magv_';

// Define language variable.
define("LSLANG", "ru");

