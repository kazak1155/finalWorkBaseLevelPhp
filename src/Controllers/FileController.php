<?php

namespace App\Controllers;

use App\Class\Files;
use App\Models\User;
use App\View\Json;
use App\View\View;


/**
 * Class FileController
 * @package App\Controllers
 */
class FileController
{
    public function showAllFiles()
    {
        $objectsJsonUser = [];

        return new Json(
            [
                'users' => json_encode($objectsJsonUser)
            ]);
    }

    public function addFile()
    {
        $message = '';
        $result = '';

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function editFile()
    {
        $message = '';
        $result = '';

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function showFileById($id)
    {
        $message ='';
        $result = '';

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function deleteFile($id)
    {
        $file = Files::find($id);
        if (isset($file)) {
            $message ='файл с ID= ' . $id . ' удален';
            $result = true;
//            $file->delete();
        } else {
            $file = '';
            $message ='файла с таким ИД нет в БД';
            $result = false;
        }

        return new Json(
            [
                'file' => $file,
                'message' => $message,
                'result' => $result
            ]);
    }
}
