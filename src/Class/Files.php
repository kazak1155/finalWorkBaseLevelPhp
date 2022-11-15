<?php

namespace App\Class;
/**
 * Files Class with all function for files
 */
class Files
{
    /**
     * Show all files in databade
     * @return files[] all files from all users
     */
    public function showAllFiles()
    {
    $files =[];
    }

    /**
     * Show all files in databade
     * @param int $id id user
     * @return files[]  all files from user with id
     */
    public function showAllFilesUser($id)
    {
        $files =[];
    }

    /**
     * delete selected file
     * @param int $id id file
     */
    public function delete($id)
    {
    }

    /**
     * upload file
     */
    public function add()
    {
    }
}