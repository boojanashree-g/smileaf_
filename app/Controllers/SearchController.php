<?php
namespace App\Controllers;
use App\Models\ProductModel;

class SearchController extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function suggestions()
    {
        $query = $this->request->getGet('query');

        if (!$query) {
            return $this->response->setJSON([]);
        }

        $builder = $this->db->table('tbl_products a');
        $builder->select('a.prod_id, a.prod_name, a.main_image, a.url, MIN(b.offer_price) as lowest_offer_price');
        $builder->join('tbl_variants b', 'a.prod_id = b.prod_id AND b.flag = 1', 'left');
        $builder->where('a.flag', 1);
        $builder->like('a.prod_name', $query);
        $builder->groupBy('a.prod_id');
        $builder->limit(10);

        $results = $builder->get()->getResultArray();

        return $this->response->setJSON($results);
    }

}
