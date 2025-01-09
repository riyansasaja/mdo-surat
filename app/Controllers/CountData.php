<?php

namespace App\Controllers;

use App\Models\ModelInmail;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CountData extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function countInbox()
    {
        //
        $data = [];
        $inboxModel = new ModelInmail();
        $inbox = $inboxModel->getMonthRecap();
        foreach ($inbox as $in) {
            $data[] = [
              'labels' => $in->MONTH,
              'values' => $in->TOTAL,
            ];
        }
       return $this->respond($data, 200);

    }public function countOutbox()
    {
        //
        $data = [];
        $inboxModel = new ModelInmail();
        $inbox = $inboxModel->getMonthRecap();
        foreach ($inbox as $in) {
            $data[] = [
              'labels' => $in->MONTH,
              'values' => $in->TOTAL,
            ];
        }
       return $this->respond($data, 200);
    }



    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
