<?php
/**
 * Shauku - An open source social networking platform.
 * Copyright (C) 2011 The Shauku Team
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 * @package JoinPage
 * @author  Alessandro Desantis <desa.alessandro@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version $Id$
 * @link    http://www.shauku.org
 */

/**
 * @ignore
 */
if (!defined('IN_APPLICATION')) {
    exit();
}

/**
 * Project's configuration.
 */
$config = array(
    // Database configuration
    'db' => array(
        // DSN (see PDO documentation for info)
        'dsn'  => 'mysql:host=localhost;dbname=example',
        // Host's username
        'user' => 'root',
        // Host's password
        'pass' => '',
    ),

    // Application's configuration
    'app' => array(
        // Show additional debug information?
        'debug_mode' => true,
        // Subscriptions' expiring time (in days)
        'expiring' => 2,
        // Default language
        'language' => 'en',
        // Default template
        'template' => 'default',
    ),

    // Site's configuration
    'site' => array(
        // Site's URL
        'url' => 'http://www.example.com',
        // Blog's URL
        'blog_url' => 'http://blog.example.com',
    ),

    // SMTP server configuration
    'email' => array(
        // Server's hostname
        'host' => 'mail.example.com',
        // Server's port
        'port' => 25,
        // Username
        'username' => 'noreply@example.com',
        // Password
        'password' => '',
        // Email in the From header (usually username)
        'from_email' => 'noreply@example.com',
    ),
);
?>
