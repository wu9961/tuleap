<?php

/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

// format : project_id  tracker_id  artifact_id value [comment]

if ($argc < 1) {
    die('Usage: ".$argv[0]." artifact_id'.PHP_EOL);
}

$serverURL = 'http://shunt.cro.enalean.com';
$soapLogin = new SoapClient($serverURL.'/soap/?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE));

// Establish connection to the server
$requesterSessionHash = $soapLogin->login('manuel','')->session_hash;

//save values
//$artifact_id = $argv[1];

// Connecting to the soap's tracker client
$soapTracker = new SoapClient($serverURL.'/plugins/tracker/soap/?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE));


$criteria = array(
    array(
        'field_name' => 'remaining_effort',
        'value' => array('value' => "bla")
    ),
    array(
        'field_name' => 'stuff_date',
        'value' => array(
            'date' => array(
                'op' => '=',
                'to_date' => '1234'
            )
        )
    )
    
);

$response = $soapTracker->getArtifacts($requesterSessionHash, 114, 276, $criteria, 0, 100);


var_dump($response);

?>
