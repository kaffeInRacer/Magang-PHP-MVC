<?php
class mahasiswa_internship_model
{
    private $table = 'magang_mandiri';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data)
    {
        $userExists = $this->checkUserExists($data['user_id']);
        if ($userExists) {
            return "User telah mengikuti magang";
        }

        $field = 'lecture';

        $findQuery = "SELECT $field FROM magang_" . $data['type'] . " WHERE id = :id";
        $this->db->query($findQuery);
        $this->db->bind(':id', $data['mitra_id']);
        $result = $this->db->single();

        if ($result !== false && isset($result[$field]) && $result[$field] > 0) {
            $insertQuery = "INSERT INTO following_internships (user_id, " . $data['type'] . "_id) VALUES (:user_id, :mitra_id)";
            $this->db->query($insertQuery);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':mitra_id', $data['mitra_id']);
            $res = $this->db->execute();

            if ($res === null) {
                // Kurangi kuota setelah berhasil insert
                $updateQuery = "UPDATE magang_" . $data['type'] . " SET $field = $field - 1 WHERE id = :id";
                $this->db->query($updateQuery);
                $this->db->bind(':id', $data['mitra_id']);
                $this->db->execute();

                return 'Berhasil Tambah Data';
            } else {
                return 'Gagal Tambah Data';
            }
        } else {
            return 'Kuota telah penuh';
        }
    }

    public function getByID($id)
    {
        $query = "SELECT fi.id as following_internship_id, u.id as user_id, u.username, 
                    CASE 
                        WHEN fi.partnership_id IS NOT NULL THEN 'partnership'
                        WHEN fi.penelitian_id IS NOT NULL THEN 'penelitian'
                        ELSE NULL 
                    END as type,
                    CASE 
                        WHEN fi.partnership_id IS NOT NULL THEN mp.id 
                        WHEN fi.penelitian_id IS NOT NULL THEN pen.id 
                        ELSE NULL 
                    END as magang_id,
                    CASE 
                        WHEN fi.partnership_id IS NOT NULL THEN mp.title 
                        WHEN fi.penelitian_id IS NOT NULL THEN pen.title 
                        ELSE NULL 
                    END as title,
                    fi.created_at 
                    FROM following_internships fi 
                    JOIN users u ON fi.user_id = u.id 
                    LEFT JOIN magang_partnership mp ON fi.partnership_id = mp.id 
                    LEFT JOIN magang_penelitian pen ON fi.penelitian_id = pen.id
                    WHERE fi.id = :id";

        $this->db->query($query);
        $this->db->bind(':id', $id);
        $result = $this->db->single();

        return $result;
    }


    public function show()
    {
        $query = "SELECT fi.id as following_internship_id, u.id as user_id, u.username, 
                CASE 
                    WHEN fi.partnership_id IS NOT NULL THEN 'partnership'
                    WHEN fi.penelitian_id IS NOT NULL THEN 'penelitian'
                    ELSE NULL 
                END as type,
                CASE 
                    WHEN fi.partnership_id IS NOT NULL THEN mp.id 
                    WHEN fi.penelitian_id IS NOT NULL THEN pen.id 
                    ELSE NULL 
                END as magang_id,
                CASE 
                    WHEN fi.partnership_id IS NOT NULL THEN mp.title 
                    WHEN fi.penelitian_id IS NOT NULL THEN pen.title 
                    ELSE NULL 
                END as title,
                fi.created_at 
                FROM following_internships fi 
                JOIN users u ON fi.user_id = u.id 
                LEFT JOIN magang_partnership mp ON fi.partnership_id = mp.id 
                LEFT JOIN magang_penelitian pen ON fi.penelitian_id = pen.id";

        $this->db->query($query);
        $result = $this->db->resultSet();

        return $result;
    }

    public function delete($ids)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {
                $query = "DELETE FROM following_internships WHERE id = ?";
                $this->db->query($query);
                $this->db->bind(1, $id);
                $this->db->execute();
            }
        } elseif (!empty($ids)) {

            $query = "DELETE FROM following_internships WHERE id = ?";
            $this->db->query($query);
            $this->db->bind(1, $ids);
            $this->db->execute();
        }
    }

    public function update($data)
    {
        $existingData = $this->getByID($data['id']);

        if ($existingData && $existingData['type'] !== $data['type']) {
            $query = "";
            if ($data['type'] === 'partnership') {
                $query = "UPDATE following_internships SET partnership_id = :mitra_id, penelitian_id = NULL, user_id = :user_id WHERE id = :id";
            } else if ($data['type'] === 'penelitian') {
                $query = "UPDATE following_internships SET penelitian_id = :mitra_id, partnership_id = NULL, user_id = :user_id WHERE id = :id";
            }

            $this->db->query($query);
            $this->db->bind(":id", $data["id"]);
            $this->db->bind(':mitra_id', $data['mitra_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $res = $this->db->execute();
            if (is_null($res)) {
                return 'Berhasil Update Data';
            } else {
                return 'Gagal Update Data';
            }
        } else {
            return false;
        }
    }


    public function getUser($username)
    {
        $query = "SELECT id, username FROM users WHERE username LIKE :username AND role = 'mahasiswa'";
        $this->db->query($query);
        $this->db->bind(':username', '%' . $username . '%');
        return $this->db->resultSet();
    }

    public function getMitraOnPenelitian($title)
    {
        $query = "SELECT id, title FROM magang_penelitian WHERE title LIKE :title";
        $this->db->query($query);
        $this->db->bind(':title', '%' . $title . '%');
        return $this->db->resultSet();
    }

    public function getMitraOnPartnership($title)
    {
        $query = "SELECT id, title FROM magang_partnership WHERE title LIKE :title";
        $this->db->query($query);
        $this->db->bind(':title', '%' . $title . '%');
        return $this->db->resultSet();
    }

    public function checkUserExists($user_id)
    {
        $query = "SELECT COUNT(*) FROM following_internships WHERE user_id = :user_id";
        $this->db->query($query);
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();

        return $result['COUNT(*)'] > 0;
    }
}
