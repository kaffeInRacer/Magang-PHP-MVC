<?php
class mandiri_model
{
    private $table = 'magang_mandiri';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data)
    {
        $query = "INSERT INTO $this->table (mitra, job, pic, number_pic) VALUES (:mitra, :job, :pic, :number_pic)";
        $this->db->query($query);
        $this->db->bind(':mitra', $data['mitra']);
        $this->db->bind(':job', $data['job']);
        $this->db->bind(':pic', $data['pic']);
        $this->db->bind(':number_pic', $data['number_pic']);
        $this->db->execute();

        $lastInsertedId = $this->db->lastInsertId();

        $query = "INSERT INTO following_internships (user_id, mandiri_id) VALUES (:user_id, :mandiri_id)";
        $this->db->query($query);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':mandiri_id', $lastInsertedId);
        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Tambah Data';
        } else {
            return 'Gagal Tambah Data';
        }
    }

    public function getByID($id)
    {
        $query = "SELECT i.id, i.mandiri_id, i.follow_date, i.created_at, i.updated_at,
                  u.id AS user_id, u.username,
                  mm.job, mm.pic, mm.number_pic, mm.mitra 
                  FROM following_internships i
                  LEFT JOIN users u ON i.user_id = u.id
                  LEFT JOIN magang_mandiri mm ON i.mandiri_id = mm.id
                  WHERE i.id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $results = $this->db->single();

        if ($results) {
            return [
                'id' => $results['id'],
                'follow_date' => $results['follow_date'],
                'created_at' => $results['created_at'],
                'updated_at' => $results['updated_at'],
                'user' => [
                    'id' => $results['user_id'],
                    'username' => $results['username']
                ],
                'mandiri' => [
                    'mitra' => $results['mitra'],
                    'job' => $results['job'],
                    'pic' => $results['pic'],
                    'number_pic' => $results['number_pic'],
                    'mandiri_id' => $results['mandiri_id'],
                ]
            ];
        } else {
            return null; // Tidak ada hasil yang cocok dengan ID yang diberikan
        }
    }


    public function show()
    {
        $query = "SELECT i.id, i.mandiri_id, i.follow_date, i.created_at, i.updated_at,
                  u.id AS user_id, u.username,
                  mm.job, mm.pic, mm.number_pic, mm.mitra 
                  FROM following_internships i
                  LEFT JOIN users u ON i.user_id = u.id
                  LEFT JOIN magang_mandiri mm ON i.mandiri_id = mm.id";
        $this->db->query($query);
        $results = $this->db->resultSet();

        $groupedResults = [];
        foreach ($results as $result) {
            $groupId = $result['id'];

            if (!isset($groupedResults[$groupId])) {
                $groupedResults[$groupId] = [
                    'id' => $result['id'],
                    'follow_date' => $result['follow_date'],
                    'created_at' => $result['created_at'],
                    'updated_at' => $result['updated_at'],
                    'user' => [
                        'id' => $result['user_id'],
                        'username' => $result['username']
                    ],
                    'mandiri' => [
                        'mitra' => $result['mitra'],
                        'job' => $result['job'],
                        'pic' => $result['pic'],
                        'number_pic' => $result['number_pic'],
                        'mandiri_id' => $result['mandiri_id'],
                    ]
                ];
            }
        }

        return array_values($groupedResults);
    }



    public function delete($ids)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {
                $query = "SELECT mandiri_id FROM following_internships WHERE id = ?";
                $this->db->query($query);
                $this->db->bind(1, $id);
                $mandiriId = $this->db->single();

                $query = "DELETE FROM following_internships WHERE id = ?";
                $this->db->query($query);
                $this->db->bind(1, $id);
                $this->db->execute();

                $query = "DELETE FROM magang_mandiri WHERE id = ?";
                $this->db->query($query);
                $this->db->bind(1, $mandiriId['mandiri_id']);
                $this->db->execute();
            }
        } elseif (!empty($ids)) {
            $query = "SELECT mandiri_id FROM following_internships WHERE id = ?";
            $this->db->query($query);
            $this->db->bind(1, $ids);
            $mandiriId = $this->db->single();

            $query = "DELETE FROM following_internships WHERE id = ?";
            $this->db->query($query);
            $this->db->bind(1, $ids);
            $this->db->execute();

            $query = "DELETE FROM magang_mandiri WHERE id = ?";
            $this->db->query($query);
            $this->db->bind(1, $mandiriId['mandiri_id']);
            $this->db->execute();
        }
    }



    public function update($data)
    {
        $query = "SELECT fi.mandiri_id, mg.id 
                  FROM following_internships fi 
                  LEFT JOIN magang_mandiri mg ON fi.mandiri_id = mg.id 
                  WHERE fi.id = :id";

        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $mitra = $this->db->single();

        $query = "UPDATE magang_mandiri 
                  SET job = :job, pic = :pic, number_pic = :number_pic, mitra = :mitra 
                  WHERE id = :id";

        $this->db->query($query);
        $this->db->bind(':id', $mitra['id']);
        $this->db->bind(':mitra', $data['mitra']);
        $this->db->bind(':job', $data['job']);
        $this->db->bind(':pic', $data['pic']);
        $this->db->bind(':number_pic', $data['number_pic']);
        $this->db->execute();

        $query = "UPDATE following_internships 
                  SET user_id = :user_id 
                  WHERE mandiri_id = :mandiri_id";

        $this->db->query($query);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':mandiri_id', $mitra['mandiri_id']);
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
