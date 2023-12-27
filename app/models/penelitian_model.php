<?php
class penelitian_model
{
    private $table = 'magang_penelitian';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data, $file)
    {
        $query = "INSERT INTO $this->table (title, description, lecture, image, author, owner_id) VALUES (:title, :description, :lecture, :image, :author, :owner_id)";
        $this->db->query($query);
        $this->db->bind(':title', $data['tittle']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':lecture', $data['lecture']);
        $this->db->bind(':author', $data['author']);
        $image  = controller::saveFile('storage/image/', $file['image'], '');
        $this->db->bind(':image', $image);
        $this->db->bind(':owner_id', $data['owner']);

        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Tambah Data';
        } else {
            return 'Gagal Tambah Data';
        }
    }

    public function getByID($id)
    {
        $query = "SELECT pm.*, s.id AS user_id, s.username FROM $this->table pm 
                  LEFT JOIN users s ON pm.owner_id = s.id 
                  WHERE pm.id = :id";

        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


    public function show()
    {
        $user = "SELECT id, username FROM users WHERE role = 'admin'";
        $this->db->query($user);
        $user = $this->db->resultSet();

        $query = "SELECT * FROM $this->table";
        $this->db->query($query);
        $query = $this->db->resultSet();

        return ['user' => $user, 'mitra' => $query];
    }

    public function delete($id)
    {
        if (is_array($id) && !empty($id)) {
            // Fetch files for deletion
            $placeholders = implode(', ', array_fill(0, count($id), '?'));
            $queryFile = "SELECT image FROM $this->table WHERE id IN ($placeholders)";
            $this->db->query($queryFile);

            foreach ($id as $key => $value) {
                $param = $key + 1;
                $this->db->bind($param, $value);
            }
            $filesToDelete = $this->db->resultSet();

            // Perform deletion
            $query = "DELETE FROM $this->table WHERE id IN (" . implode(', ', array_fill(0, count($id), '?')) . ")";
            $this->db->query($query);
            foreach ($id as $key => $value) {
                $param = $key + 1;
                $this->db->bind($param, $value);
            }
            $this->db->execute();

            // Delete associated files
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
        $oldData = $this->getByID($data["id"]);
        $oldImage = $oldData['image'];

        $query = "UPDATE $this->table SET 
            title = :name, 
            lecture = :lecture, 
            description = :description,
            author = :author,
            owner_id = :owner_id";


        // Periksa dan tambahkan kolom yang diperlukan untuk file baru 'image' jika diunggah
        if ($file["image"]["name"] != "") {
            $query .= ", image = :new_image";
            $newImage = controller::saveFile('storage/image/', $file["image"], $oldImage);
        } else {
            $newImage = $oldImage;
        }

        // Tambahkan kondisi WHERE dan bind semua parameter
        $query .= " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['tittle']); // Pastikan 'tittle' yang benar
        $this->db->bind(':lecture', $data['lecture']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':owner_id', $data['owner']);

        // Bind parameter untuk file baru 'image' jika diunggah
        if ($file["image"]["name"] != "") {
            $this->db->bind(':new_image', $newImage);
        }

        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Update Data';
        } else {
            return 'Gagal Update Data';
        }
    }

    public function fetch($page, $itemsPerPage)
    {
        $request = true;

        $queryCount = "SELECT COUNT(user_id) as count FROM following_internships WHERE user_id = :id";
        $this->db->query($queryCount);
        $this->db->bind(':id', $_SESSION['user']['id']);
        $result = $this->db->single();

        if ($result['count'] > 0) {
            $request = false;
        }

        $offset = ($page - 1) * $itemsPerPage;
        $query = "SELECT id, title, author, description, lecture, image FROM $this->table LIMIT :itemsPerPage OFFSET :offset";
        $this->db->query($query);
        $this->db->bind(':itemsPerPage', $itemsPerPage);
        $this->db->bind(':offset', $offset);

        $results = $this->db->resultSet();

        foreach ($results as &$result) {
            if ($result['lecture'] === '0') {
                $result['status'] = false;
            } else {
                $result['status'] = true;
            }
        }

        return [$results, $request];
    }

    public function countTotalItems()
    {
        $query = "SELECT COUNT(*) AS total FROM $this->table";
        $this->db->query($query);
        $result = $this->db->single();
        return (int) $result;
    }


    public function search($searchTerm)
    {
        $request = true;

        $queryCount = "SELECT COUNT(user_id) as count FROM following_internships WHERE user_id = :id";
        $this->db->query($queryCount);
        $this->db->bind(':id', $_SESSION['user']['id']);
        $result = $this->db->single();

        if ($result['count'] > 0) {
            $request = false;
        }

        $searchTerm = '%' . $searchTerm . '%';
        $query = "SELECT id, title, author, description, lecture, image FROM $this->table WHERE title LIKE :searchTerm";
        $this->db->query($query);
        $this->db->bind(':searchTerm', $searchTerm);

        $data = $this->db->resultSet();

        foreach ($data as &$item) {
            $item['request'] = $request;
        }

        return $data;
    }
}
