<?php

namespace App\Service;

class SaveFiles{
    /**
     * saves a file with a unique id and returns the unique name with extension
     *
     * @param [type] $dumpImage
     * @return string
     */
    public function saveImageWithUniqueId($dumpImage){
        $imageUniqueId = uniqid('dump') . '.' . $dumpImage->getClientOriginalExtension();
        
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/images/dumps/' . $imageUniqueId , file_get_contents($dumpImage));

        return $imageUniqueId;
    }
}