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
 * Sets the page's title.
 */
$tpl = Template::getInstance();
$tpl->assign('page_title', $lang['join_shauku_title']);

/**
 * Checks if the form was sent.
 */
if (isset($_POST['submit'])) {
    /**
     * Gets the form's data.
     */
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    /**
     * Validates the input.
     */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == 'john@example.com') {
        $tpl->showError($lang['invalid_email']);
    }

    /**
     * Checks if the e-mail has been already added into the database.
     */
    try {
        new Subscription($email);
        $created = true;
    }
    catch (Exception $e) {
        $created = false;
    }

    /**
     * Checks if the e-mail already exists.
     */
    if ($created) {
        $tpl->showError($lang['already_exists']);
    }

    /**
     * Adds the subscription to the database.
     */
    $subscription = Subscription::create($email);

    /**
     * Checks if the subscription was created correctly.
     */
    if ($subscription) {
        /**
         * Sets the template's variables.
         */
        $tpl->assign('page_title', $lang['subscription_added']);
        $tpl->assign('email', $email);

        /**
         * Shows the success message.
         */
        $tpl->display('subscription_added.html');
    }
    /**
     * There was an error while creating the subscription.
     */
    else {
        /**
         * Shows the error message.
         */
        $tpl->showError($lang['subscription_error']);
    }
}
/**
 * The form was not sent.
 */
else {
    /**
     * Sets the number of subscriptions so far.
     */
    $tpl->assign('subscriptions', Subscription::getActive());

    /**
     * Shows the form.
     */
    $tpl->display('subscribe_body.html');
}
?>
