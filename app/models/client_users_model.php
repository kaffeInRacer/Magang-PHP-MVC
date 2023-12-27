<?php
class client_users_model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data)
    {
        $query = "SELECT 
        (SELECT COUNT(email) FROM $this->table WHERE email = :email) as email_count,
        (SELECT COUNT(nim) FROM $this->table WHERE nim = :nim) as nim_count";

        $this->db->query($query);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':nim', $data['nim']);
        $counts = $this->db->single();

        if ($counts['email_count'] > 0) {
            return [
                'status' => false,
                'msg' => 'Email telah digunakan'
            ];
        }

        if ($counts['nim_count'] > 0) {
            return [
                'status' => false,
                'msg' => 'Nim telah digunakan'
            ];
        }

        $query = "INSERT INTO $this->table (username, password, email, nim, telp, gender, role) 
                  VALUES (:username, :password, :email, :nim, :telp, :gender, :role)";
        $this->db->query($query);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':nim', $data['nim']);
        $this->db->bind(':telp', $data['telp']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':role', 'mahasiswa');

        $res = $this->db->execute();

        if (is_null($res)) {
            return true;
        } else {
            return false;
        }
    }



    public function getByID($id)
    {
        $query = "SELECT username, email, nim, telp, gender, role, image FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


    public function login($email, $password)
    {
        $query = "SELECT id, password, role FROM $this->table WHERE email = :email";
        $this->db->query($query);
        $this->db->bind(':email', $email);
        $user = $this->db->single();

        if ($user) {
            $hashedPassword = $user['password'];
            if (password_verify($password, $hashedPassword)) {
                return ['status' => true, 'user' => $user];
            } else {
                return ['status' => false, 'msg' => 'Password salah'];
            }
        } else {
            return ['status' => false, 'msg' => 'Email tidak ditemukan'];
        }
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
}
