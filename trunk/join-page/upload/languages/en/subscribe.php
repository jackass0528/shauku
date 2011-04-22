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
 * English language - subscribe
 */
$lang['join_shauku_title']    = 'Join Shauku!';
$lang['invalid_email']        = 'You entered an invalid e-mail.';
$lang['subscription_added']   = 'Almost done!';
$lang['subscription_error']   = 'There was an error while creating your subscription.';
$lang['join_shauku']          = 'Enter your e-mail address and you might be the first to try the new revolutionary open source social networking platform!';
$lang['subscribe']            = 'Subscribe!';
$lang['subscriptions']        = 'We have %s subscription(s) so far.';
$lang['confirmation_sent']    = 'A confirmation link has been sent to:';
$lang['confirm_subscription'] = 'You must click it within %d day(s) in order to complete your subscription and be able to receive an invitation!';
$lang['already_exists']       = 'You have already subscribed for an invitation.';
$lang['email_subject']        = 'Confirm your subscription';
$lang['email_text']           = "Thank you for subscribing to Shauku. In order to complete the process, you must click on the link below:\n";
$lang['email_text']           .= "----------------------------------------------------------------------------------------------------\n";
$lang['email_text']           .= "%s\n";
$lang['email_text']           .= "----------------------------------------------------------------------------------------------------\n";
$lang['email_text']           .= "If you don't click the link within %d day(s), your subscription will be deleted.\n\n";
$lang['email_signature']      = 'Regards,';
$lang['team_name']            = 'The Shauku Team';
$lang['go_to_blog']           = 'Have a look at our blog, too!';
?>
