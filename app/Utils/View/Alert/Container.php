<?php

namespace IXP\Utils\View\Alert;

/**
 * A class to encapsulate Bootstrap v3 messages.
 *
 * Copyright (C) 2009 - 2020 Internet Neutral Exchange Association Company Limited By Guarantee.
 * All Rights Reserved.
 *
 * This file is part of IXP Manager.
 *
 * IXP Manager is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, version v2.0 of the License.
 *
 * IXP Manager is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License v2.0
 * along with IXP Manager.  If not, see:
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */
 
/**
 * Alert
 *
 * @author Barry O'Donovan <barry@islandbridgenetworks.ie>
 * @copyright  Copyright (C) 2009 - 2020 Internet Neutral Exchange Association Company Limited By Guarantee.
 */
class Container
{
    /**
     * Push a message onto the message stack
     * @param string    $message
     * @param string    $class
     * @param bool      $clear
     *
     * @return void
     */
    public static function push( string $message, string $class = Alert::INFO, $clear = false ): void
    {
        if( $clear || !( $alerts = session('ixp.utils.view.alerts') ) ) {
            $alerts = [];
        }

        $alerts[] = new Alert( $message, $class );
        session( [ 'ixp.utils.view.alerts' => $alerts ] );
    }

    /**
     * Pop an alert off the message stack
     *
     * FIXME: when PHP 7.1 is a req, fix the return type
     *
     * @return Alert null for none ( === null)
     */
    public static function pop()
    {
        $alerts = session('ixp.utils.view.alerts');

        if( !$alerts || !count($alerts) ) {
            return null;
        }

        $alert = array_pop($alerts);
        session(['ixp.utils.view.alerts' => $alerts]);
        return $alert;
    }

    /**
     * Turn alerts into (safe) HTML
     *
     * @return string
     */
    public static function html(): string
    {
        $alerts = '';
        $color = '';

        while( $alert = self::pop() ) {
            switch ($alert->class()) {
                case 'danger':
                    $icon = "fa-exclamation-triangle";
                    $color = "red";
                    break;
                case 'info':
                    $icon = "fa-info-circle";
                    $color = "blue";
                    break;
                case 'success':
                    $icon = "fa-check-circle";
                    $color = "green";
                    break;
                case 'warning':
                    $icon = "fa-exclamation-circle";
                    $color = "orange";
                    break;
            }

            $alerts .= '<div class="tw-bg-' . $color . '-100 tw-border-l-4 tw-border-' . $color . '-500 tw-text-' . $color . '-700 p-4 alert-dismissible mb-4" role="alert">' . "\n"
                . '<div class="d-flex align-items-center">'
                . '<div class="text-center"><i class="fa ' . $icon . ' fa-2x "></i></div>'
                . '<div class="col-sm-12">' . clean( $alert->message() ) . "</div> \n"
                . '</div></div>' . "\n\n";
        }

        return $alerts;
    }
}