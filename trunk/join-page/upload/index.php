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
 * Direct access prevention system.
 */
define('IN_APPLICATION', true);

/**
 * Loads the configuration.
 */
require_once 'config.php';

/**
 * Sets the appropriate settings depending on the debug mode.
 */
if ($config['app']['debug_mode']) {
    error_reporting(E_ALL);
}
else {
    error_reporting(0);
}

/**
 * Loads the libraries.
 */
require_once 'includes/SwiftMailer/swift_required.php';
require_once 'includes/Database/Database.php';
require_once 'includes/Subscription.php';
require_once 'includes/Template.php';

/**
 * Gets the language to load.
 */
$user_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if (!is_dir("languages/{$user_lang}/") || !is_readable("languages/{$user_lang}/")) {
    $user_lang = $config['app']['language'];
}

/**
 * Loads the language data.
 */
$lang = array();
$lang_files = glob("languages/{$user_lang}/*.php");
foreach ($lang_files as $file) {
    require $file;
}

/**
 * Starts recording errors.
 */
$errors = array();

/**
 * Clears the expired subscriptions.
 */
Subscription::clear();

/**
 * Gets the requested module.
 */
$module   = isset($_GET['module']) ? trim($_GET['module']) : 'subscribe';
$mod_path = "modules/{$module}/main.php";

/**
 * Is this a 404 error?
 */
if (!file_exists($mod_path) || (isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == '404')) {
    /**
     * Sets the requested page's path.
     */
    $tpl = Template::getInstance();
    $tpl->assign('path', $_SERVER['REQUEST_URI']);

    /**
     * Shows the error and stops the execution.
     */
    $tpl->display('errors/page_not_found.html');
    exit();
}

/**
 * If no errors occurred till now it is time to load the module!
 */
require_once $mod_path;
?>
