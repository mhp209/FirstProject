<?php

/**
 * Created by vscode.
 * User: admin
 * Date: 18/07/2023
 * Time: 3:12 PM
 */

// / file : app/config/constants.php /

// $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$root = $scheme . $host;

$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

// $root = 'http://192.168.1.4/roadsathi/';

@define('BASE_URL',env('BASE_URL', $root."/"));
@define('ASSET_URL',env('APP_URL', 'http://localhost')."/");
@define('SITE_URL',env('SITE_URL', $root));

//defined('SITE_URL') OR define('SITE_URL', $root);
@define('VEHICLE_IMG_DIR',env('VEHICLE_IMG_DIR', public_path('uploads/VehicleImage/')));
@define('VEHICLE_DIR',env('VEHICLE_DIR', public_path('uploads/VehicleDocument/')));
@define('VEHICLE_BARCODE_IMR_DIR',env('VEHICLE_BARCODE_IMR_DIR', public_path('uploads/VehicleBarcodeImage/')));

@define('VEHICLE_IMG_URL',env('VEHICLE_IMG_URL', SITE_URL.'public/uploads/VehicleImage/'));
@define('VEHICLE_URL',env('VEHICLE_URL', SITE_URL.'public/uploads/VehicleDocument/'));
@define('VEHICLE_BARCODE_IMR_URL',env('VEHICLE_BARCODE_IMR_URL', SITE_URL.'public/uploads/BannerImage/'));

@define('INSURANCE_IMAGE',env('INSURANCE_IMAGE', SITE_URL.'public/uploads/InsuranceImage/'));
@define('HELPLINE_NUMBER',env('HELPLINE_NUMBER', "1234567895"));
@define('VEHICLE_MESSAGE',env('VEHICLE_MESSAGE', "You have scanned #owner_name Road Sathi RS Safety Tag (#vehicle_number). You can now communicate with #owner_name by choosing one of our pre defined message."));

@define('RS_SAFETY_PRICE',env('RS_SAFETY_PRICE', "599.00"));

@define('MAIL',env('MAIL', "info@roadsathi.in"));
@define('MOBILE_NO',env('MOBILE_NO', "+91 8401177585"));
@define('SALES_NO',env('SALES_NO', "+91 987 987 5066"));
@define('LOCATION',env('LOCATION', "B-203, Shukan Homes, Opp. Kalasagar Heights, New Ranip, Ahmedabad - 382470. India."));

@define('API_INSURANCE_IMAGE',env('API_INSURANCE_IMAGE', SITE_URL.'public/api/images/ic_insurance_placholder.png'));
