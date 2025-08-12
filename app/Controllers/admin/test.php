<?php 


if ($MainImg && $MainImg->isValid()) {

                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                $maxSize = 20971520;

                if ($MainImg->getSize() > $maxSize) {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Main image must be less than 20MB.'
                    ]);
                }

                if (!in_array($MainImg->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Invalid image type. Only JPG, JPEG, PNG allowed.'
                    ]);
                }

                if (in_array($MainImg->getMimeType(), $allowedTypes)) {

                    if ($MainImg->getSize() < $maxSize) { // 25 MB 

                        $newName = pathinfo($MainImg->getRandomName(), PATHINFO_FILENAME) . '.webp';
                        $savePath = FCPATH . 'uploads/' . $newName;

                        // Convert uploaded file to WebP
                        \Config\Services::image()
                            ->withFile($MainImg->getTempName())
                            ->convert(IMAGETYPE_WEBP)
                            ->save($savePath, 90);

                        $data['main_image'] = '/uploads/' . $newName;

                    } else {
                        return $this->response->setJSON([
                            'code' => 400,
                            'status' => 'error',
                            'msg' => 'Main image must be less than 20MB.'
                        ]);
                    }

                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Invalid image type. Only JPG, JPEG, PNG allowed.'
                    ]);
                }

            } else {
                $data['main_image'] = null;
            }




                foreach ($images['images'] as $subImg) {
                        if ($subImg->isValid()) {
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                            if (in_array($subImg->getMimeType(), $allowedTypes)) {
                                if ($subImg->getSize() <= 20971520) {  // 20 MB
                                    $newName = pathinfo($subImg->getRandomName(), PATHINFO_FILENAME) . '.webp';
                                    $savePath = FCPATH . 'uploads/' . $newName;

                                    // Convert uploaded file to WebP
                                    \Config\Services::image()
                                        ->withFile($subImg->getTempName())
                                        ->convert(IMAGETYPE_WEBP)
                                        ->save($savePath, 90);

                                    $imageData = [
                                        'prod_id' => $lastInsertedID,
                                        'image_path' => '/uploads/' . $newName,
                                    ];

                                    $ImageModel->insert($imageData);
                                } else {
                                    return $this->response->setJSON([
                                        'code' => 400,
                                        'status' => 'error',
                                        'msg' => 'Images  must be less than 20MB.'
                                    ]);
                                }
                            } else {
                                return $this->response->setJSON([
                                    'code' => 400,
                                    'status' => 'error',
                                    'msg' => 'Invalid image type. Only JPG, JPEG, PNG allowed.'
                                ]);
                            }
                        }
                    }

                    