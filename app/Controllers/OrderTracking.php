<?php

namespace App\Controllers;

class OrderTracking extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function trackOrder()
    {
        try {
            $orderData = $this->request->getGet('orderid');

            if (empty($orderData)) {
                throw new \Exception("Order ID is missing in request");
            }

            $orderID = base64_decode($orderData, true);
            if ($orderID === false || !is_numeric($orderID)) {
                throw new \Exception("Invalid Order ID");
            }

            $trackQry = "SELECT `tracking_id`, `courier_partner` 
                      FROM `tbl_orders` 
                      WHERE `flag` = 1 AND `order_id` = ?";
            $trackingData = $this->db->query($trackQry, [$orderID])->getRow();

            if (!$trackingData) {
                throw new \Exception("No tracking data found for Order ID: {$orderID}");
            }

            $tracking_url = rtrim($_ENV['TRACKING_URL'], '/') . '/';
            $courierPartner = strtolower(str_replace(' ', '-', $trackingData->courier_partner));
            $trackingID = $trackingData->tracking_id;

            if (empty($trackingID)) {
                throw new \Exception("Tracking ID is missing for Order ID: {$orderID}");
            }

            $final_url = "{$tracking_url}{$courierPartner}/{$trackingID}";



            return redirect()->to($final_url);


        } catch (\Throwable $e) {

            log_message('error', 'TrackOrder Error: ' . $e->getMessage());
            echo "Unable to track order at the moment. Please try again later.";
        }
    }
}