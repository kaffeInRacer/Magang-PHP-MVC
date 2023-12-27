<?php
class partnership_model
{
    private $table = 'magang_partnership';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data, $file)
    {

        $query = "INSERT INTO $this->table (title, description, lecture, image, mou_file ,address) VALUES (:title, :description, :lecture, :image, :mou_file, :address)";
        $this->db->query($query);
        $this->db->bind(':title', $data['tittle']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':lecture', $data['lecture']);
        $this->db->bind(':address', $data['address']);
        $mou    = controller::saveFile('storage/mou/', $file['mou'], '');
        $image  = controller::saveFile('storage/image/', $file['image'], '');
        $this->db->bind(':image', $image);
        $this->db->bind(':mou_file', $mou);

        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Tambah Data';
        } else {
            return 'Gagal Tambah Data';
        }
    }

    public function getByID($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function show()
    {
        $query = "SELECT * FROM $this->table";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function delete($id)
    {
        if (is_array($id) && !empty($id)) {
            $placeholders = implode(', ', array_fill(0, count($id), '?'));
            $queryFile = "SELECT image, mou_file FROM $this->table WHERE id IN ($placeholders)";
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
                if ($file['mou_file'] !== "" && file_exists($file['mou_file'])) {
                    unlink($file['mou_file']);
                }

                if ($file['image'] !== "" && file_exists($file['image'])) {
                    unlink($file['image']);
                }
            }
        } elseif (!empty($id)) {
            $queryFile = "SELECT image, mou_file FROM $this->table WHERE id = ?";
            $this->db->query($queryFile);
            $this->db->bind(1, $id);
            $file = $this->db->single();

            $query = "DELETE FROM $this->table WHERE id = ?";
            $this->db->query($query);
            $this->db->bind(1, $id);
            $this->db->execute();

            if ($file && $file['mou_file'] !== "" && file_exists($file['mou_file'])) {
                unlink($file['mou_file']);
            }

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
        $oldFile = $oldData['mou_file'];
        $oldImage = $oldData['image'];

        $query = "UPDATE $this->table SET 
            title = :name, 
            lecture = :lecture, 
            description = :description";

        if ($file["mou"]["name"] != "") {
            $query .= ", mou_file = :new_mou_file";
            $newFile = controller::saveFile('storage/mou/', $file["mou"], $oldFile);
        } else {
            $newFile = $oldFile;
        }

        if ($file["image"]["name"] != "") {
            $query .= ", image = :new_image";
            $newImage = controller::saveFile('storage/image/', $file["image"], $oldImage);
        } else {
            $newImage = $oldImage;
        }

        $query .= " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['tittle']);
        $this->db->bind(':lecture', $data['lecture']);
        $this->db->bind(':description', $data['description']);

        if ($file["mou"]["name"] != "") {
            $this->db->bind(':new_mou_file', $newFile);
        }

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
        $query = "SELECT id, title, address, description, lecture, image FROM $this->table LIMIT :itemsPerPage OFFSET :offset";
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
        $query = "SELECT id, title, address, description, lecture, image FROM $this->table WHERE title LIKE :searchTerm";
        $this->db->query($query);
        $this->db->bind(':searchTerm', $searchTerm);

        $data = $this->db->resultSet();

        foreach ($data as &$item) {
            $item['request'] = $request;
        }

        return $data;
    }
}
