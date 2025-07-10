<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;


class OrderController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function orderDetails()
    {

        return view("admin/order_details");
    }

    public function getData()
    {
        $orderqry = "SELECT
                        a.*,
                        b.username,
                        b.number,
                        b.email,
                        DATE_FORMAT(a.order_date, '%d-%m-%Y') AS orderdate
                    FROM
                        tbl_orders AS a
                    INNER JOIN tbl_users AS b
                    ON
                        a.`user_id` = b.user_id
                    WHERE
                        a.flag = 1 AND b.flag = 1 AND a.order_status <> 'initiated';";

        $orderDetails = $this->db->query($orderqry)->getResultArray();

        echo json_encode($orderDetails);
    }

}