<?php

namespace App\Controllers;

use App\Class\Files;
use App\Models\File;
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

        $files = File::where(null)
            ->get();
        $objectsJsonUser = [];
        foreach ($files as $file) {
            $objectsJsonUser[] = [
                [
                    'id' => $file->id,
                    'name' => $file->name,
                    'path' => $file->path,
                    'directory' => $file->directory,
                    'created_at' => $file->created_at,
                    'updated_at' => $file->updated_at,
                ]
            ];
        }

        return new Json(
            [
                'files' => json_encode($objectsJsonUser)
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
        $file = Files::find($id);
        $objectsJsonUser[] = [
            [
                'id' => $file->id,
                'name' => $file->name,
                'path' => $file->path,
                'directory' => $file->directory,
                'created_at' => $file->created_at,
                'updated_at' => $file->updated_at,
            ]
        ];


        return new Json(
            [
                'files' => json_encode($objectsJsonUser)
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

    public function showFileForm()
    {
        $title = 'страница для загрузки файла';

        return new View('file.fileForm',
            [
                'title' => $title,
            ]);
    }
}
