<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Paket
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller REST
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

use chriskacerguis\RestServer\RestController;

class Paket extends RestController
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('mPaket', 'pkt');
  }

  public function index_get()
  {
    $id = $this->get('id_paket', true);
    if ($id === null) {
      $page = $this->get('page');
      $page = (empty($page) ? 1 : $page);
      $total_data = $this->pkt->count();
      $total_page = ceil($total_data / 5);
      $start = ($page - 1) * 5;
      $list =  $this->pkt->get(null, 5, $start);
      if ($list) {
        $data = [
          'status' => true,
          'page' => $page,
          'total data' => $total_data,
          'total page' => $total_page,
          'data' => $list
        ];
      } else {
        $data = [
          'status' => false,
          'msg' => 'Paket Tidak di Temukan'
        ];
      }

      $this->response($data, RestController::HTTP_OK);
    } else {
      $data = $this->pkt->get($id);
      if ($data) {
        $this->response([
          'status' => true,
          'data' => $data
        ], RestController::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'msg' => $id . ' Paket Tidak di Temukan'
        ], RestController::HTTP_NOT_FOUND);
      }
    }
  }
  public function index_post()
  {
    $data = [
      'paket' => $this->post('paket', true),
      'waktu' => $this->post('waktu', true)
    ];
    $simpan = $this->pkt->add($data);
    if ($simpan['status']) {
      $this->response([
        'status' => true,
        'msg' => $simpan['data'] . ' Paket Telah di tambahkan'
      ], RestController::HTTP_CREATED);
    } else {
      $this->response([
        'status' => false,
        'msg' => $simpan['msg']
      ], RestController::HTTP_INTERNAL_ERROR);
    }
  }
  public function index_put()
  {
    $data = [
      'paket' => $this->put('paket', true),
      'waktu' => $this->put('waktu', true)
    ];
    $id = $this->put('id_paket');
    if ($id === null) {
      $this->response([
        'status' => false,
        'msg' => 'Masukkan paket'
      ], RestController::HTTP_BAD_REQUEST);
    }
    $simpan = $this->pkt->update($id, $data);
    if ($simpan['status']) {
      $status = (int)$simpan['data'];
      if ($status > 0) {
        $this->response([
          'status' => true,
          'msg' => $simpan['data'] . ' Paket Telah di Rubah'
        ], RestController::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'msg' => 'Tidak ada Paket yang di rubah'
        ], RestController::HTTP_BAD_REQUEST);
      }
    } else {
      $this->response([
        'status' => false,
        'msg' => $simpan['msg']
      ], RestController::HTTP_INTERNAL_ERROR);
    }
  }
  public function index_delete()
  {
    $id = $this->delete('id_paket', true);
    if ($id === null) {
      $this->response([
        'status' => false,
        'msg' => 'Masukkan Id_paket'
      ], RestController::HTTP_BAD_REQUEST);
    }
    $delete = $this->pkt->delete($id);
    if ($delete['status']) {
      $status = (int)$delete['data'];
      if ($status > 0) {
        $this->response([
          'status' => true,
          'msg' => $delete['data'] . ' Paket Telah di Hapus'
        ], RestController::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'msg' => 'Tidak ada Paket yang di hapus'
        ], RestController::HTTP_BAD_REQUEST);
      }
    } else {
      $this->response([
        'status' => false,
        'msg' => $delete['msg']
      ], RestController::HTTP_INTERNAL_ERROR);
    }
  }
}


/* End of file Paket.php */
/* Location: ./application/controllers/Paket.php */