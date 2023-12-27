<?php

class Auth_input
{
    public function validateRegistrationInput($request)
    {
        $errors = [];

        if (empty($request['username']) && empty($request['nip']) && empty($request['email']) && empty($request['password']) && empty($request['telp']) && empty($request['jurusan']) && empty($request['gender'])) {
            $errors[] = 'MOHON ISI SEMUA DATA DI BAWAH INI';
        } else {
            // Cek masing-masing field
            if (empty($request['username'])) {
                $errors['username'] = 'Username harus diisi';
            }

            if (empty($request['nik'])) {
                $errors['nik'] = 'NIP harus diisi';
            }

            if (empty($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email harus diisi dengan format yang benar';
            }

            if (empty($request['password']) || strlen($request['password']) < 6) {
                $errors['password'] = 'Password harus diisi dan memiliki minimal 6 karakter';
            }

            if (empty($request['telp'])) {
                $errors['telp'] = 'No Telp harus diisi';
            }

            if (empty($request['jurusan'])) {
                $errors['jurusan'] = 'Jurusan harus diisi';
            }

            if (empty($request['gender'])) {
                $errors['gender'] = 'Jenis Kelamin harus diisi';
            }
        }

        return $errors;
    }

    public function validateLoginInput($request)
    {
        $errors = [];

        if (empty($request['email']) && empty($request['password'])) {
            $errors[] = 'MOHON ISI SEMUA DATA DI BAWAH INI';
        } else {
            if (empty($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email harus diisi dengan format yang benar';
            }

            if (empty($request['password'])) {
                $errors['email'] = 'Password tidak boleh kosong';
            }
        }

        return $errors;
    }
}
