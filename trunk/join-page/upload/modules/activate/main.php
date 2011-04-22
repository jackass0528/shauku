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
 * Gets the activation code.
 */
$code = isset($_GET['code']) ? trim($_GET['code']) : '';

/**
 * Gets the instance of the template engine.
 */
$tpl = Template::getInstance();

/**
 * Checks whether a code was specified.
 */
if ($code == '') {
    $tpl->showError($lang['invalid_code']);
}

/**
 * Checks if the code exists.
 */
try {
    $subscription = new Subscription($code);
}
/**
 * The code does not exist.
 */
catch (Exception $e) {
    /**
     * Sets the specified code.
     */
    $tpl->assign('code', $code);

    /**
     * Shows an error.
     */
    $tpl->showError($lang['invalid_code']);
}

/**
 * Activates the subscription.
 */
if (!$subscription->activate()) {
    /**
     * Shows an error: the subscription has been already activated.
     */
    $tpl->showError($lang['already_activated']);
}

/**
 * Sets the template's variables.
 */
$tpl->assign('page_title', $lang['activated_title']);
$tpl->assign('email', $subscription->email);

/**
 * Shows a success message.
 */
$tpl->display('subscription_activated.html');
?>
