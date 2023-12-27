<?php
class users_model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data, $file)
    {
        $query = "INSERT INTO $this->table (username, password, email, nim, telp, gender, role, image) 
                  VALUES (:username, :password, :email, :nim, :telp, :gender, :role, :image)";
        $this->db->query($query);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':nim', $data['nim']);
        $this->db->bind(':telp', $data['telp']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':role', 'mahasiswa');

        $image = '';
        if (isset($file['image']) && is_array($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            $image = controller::saveFile('storage/image/', $file['image'], '');
        }

        $this->db->bind(':image', $image);

        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Tambah Data';
        } else {
            return 'Gagal Tambah Data';
        }
    }

    public function getByID($id)
    {
        $query = "SELECT username, email, nim, telp, gender, role, image FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


    public function show()
    {
        $query = "SELECT id,username, email, nim, telp, gender, role, image FROM $this->table WHERE role = 'mahasiswa'";
        $this->db->query($query);
        $user = $this->db->resultSet();
        return ['user' => $user];
    }



    public function delete($id)
    {
        if (is_array($id) && !empty($id)) {
            $placeholders = implode(', ', array_fill(0, count($id), '?'));
            $queryFile = "SELECT image FROM $this->table WHERE id IN ($placeholders)";
            $this->db->query($queryFile);

            foreach ($id as $key => $value) {
                $param = $key + 1;
                $this->db->bind($param, $value);
            }
            $filesToDelete = $this->db->resultSet();

            $query = "DELETE FROM $this->table WHERE id IN (" . implode(', ', array_fill(0, count($id), '?')) . ")";
            $this->db->query($query);
            foreach ($id as $key => $value) {
                $param = $key + 1;
                $this->db->bind($param, $value);
            }
            $this->db->execute();

            foreach ($filesToDelete as $file) {
                if ($file['image'] !== "" && file_exists($file['image'])) {
                    unlink($file['image']);
                }
            }
        } elseif (!empty($id)) {
            $queryFile = "SELECT image FROM $this->table WHERE id = ?";
            $this->db->query($queryFile);
            $this->db->bind(1, $id);
            $file = $this->db->single();

            $query = "DELETE FROM $this->table WHERE id = ?";
            $this->db->query($query);
            $this->db->bind(1, $id);
            $this->db->execute();

            if ($file && $file['image'] !== "" && file_exists($file['image'])) {
                unlink($file['image']);
            }
        } else {
            return 'err';
        }
    }


    public function update($data, $file)
    {
        $query = "SELECT image FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $existingImage = $this->db->single()['image'];

        $query = "UPDATE $this->table 
                  SET username = :username, password = :password, 
                      email = :email, nim = :nim, telp = :telp, 
                      gender = :gender, role = :role, image = :image
                  WHERE id = :id";

        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':nim', $data['nim']);
        $this->db->bind(':telp', $data['telp']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':role', 'mahasiswa');

        if ($file['image']['name'] !== '') {
            $imagePath = controller::saveFile('storage/image/', $file['image'], $existingImage);
            $this->db->bind(':image', $imagePath);
        } else {
            $this->db->bind(':image', $existingImage);
        }

        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Update Data';
        } else {
            return 'Gagal Update Data';
        }
    }



    public function getUser($username)
    {
        $query = "SELECT id, username FROM users WHERE username LIKE :username AND role = 'mahasiswa'";
        $this->db->query($query);
        $this->db->bind(':username', '%' . $username . '%');
        return $this->db->resultSet();
    }
}
