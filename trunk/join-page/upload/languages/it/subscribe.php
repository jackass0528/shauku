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
 * Italian language - subscribe
 */
$lang['join_shauku_title']    = 'Registrati a Shauku!';
$lang['invalid_email']        = 'Hai inserito un\'email non valida.';
$lang['subscription_added']   = 'Quasi fatto!';
$lang['subscription_error']   = 'C\'è stato un errore durante la creazione della sottoscrizione.';
$lang['join_shauku']          = 'Inserisci il tuo indirizzo e-mail qui sotto e potresti essere il primo a provare la nuova rivoluzionaria piattaforma di social networking open source!';
$lang['subscribe']            = 'Sottoscriviti!';
$lang['subscriptions']        = 'Abbiamo %s sottoscrizione(i) per ora.';
$lang['confirmation_sent']    = 'Un link di conferma è stato inviato a:';
$lang['confirm_subscription'] = 'Devi cliccarlo entro %d giorno(i) per attivare la tua sottoscrizione e poter ricevere un invito!';
$lang['already_exists']       = 'Ti sei già sottoscritto per la ricezione di un invito.';
$lang['email_subject']        = 'Conferma la tua sottoscrizione';
$lang['email_text']           = "Grazie per esserti sottoscritto a Shauku. Per completare il processo devi cliccare il link qui sotto:\n";
$lang['email_text']           .= "----------------------------------------------------------------------------------------------------\n";
$lang['email_text']           .= "%s\n";
$lang['email_text']           .= "----------------------------------------------------------------------------------------------------\n";
$lang['email_text']           .= "Se non clicchi il link entro %d giorno(i) la tua sottoscrizione sarà cancellata.\n\n";
$lang['email_signature']      = 'Saluti,';
$lang['team_name']            = 'Il team di Shauku';
$lang['go_to_blog']           = 'Dai un\'occhiata al nostro blog!';
?>
