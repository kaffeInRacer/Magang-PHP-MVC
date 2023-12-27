<?php

class Controller
{

    public function view($template, $data = [])
    {
        require_once 'app/views/' . $template . '.php';
    }

    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model;
    }

    public function validation($validation)
    {
        require_once 'app/validation/' . $validation . '.php';
        return new $validation;
    }

    public static function saveFile($path, $file, $oldFile)
    {
        if ($file['name'] === '') return '';
        // Membuat UUID baru
        $newFileName = uniqid();

        // Mendapatkan ekstensi file dari nama file yang diunggah
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Menyusun path lengkap file baru dengan ekstensi
        $filePath = $path . $newFileName . '.' . $fileExtension;

        if (!file_exists($path)) {
            mkdir($path, 777, true); // Buat direktori jika belum ada
        }

        // Menghapus file lama jika ada dan parameter $deleteOldFile disetel ke true
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $filePath; // Mengembalikan path file yang berhasil disimpan
        } else {
            return ''; // Mengembalikan string kosong jika gagal
        }
    }

    public function GlobalID()
    {
        if (isset($_SESSION["id"])) {
            $data = $this->model('User_model')->findUserID($_SESSION["id"]);
            return $data;
        } else {
            return null;
        }
    }

    public function GlobalFiture()
    {
        $data = $this->model('mahasiswa_internship_model')->checkUserExists($_SESSION['user']['id']);
        return $data;
    }
}
