<?php
class mitra_model
{
    private $table = 'mitra';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data, $file)
    {
        $query = "INSERT INTO $this->table (name,lecture,description, image, mou_file, mitra_type_id) VALUES (:name, :lecture, :description, :image, :mou_file, :mitra_type_id)";

        $this->db->query($query);
        $this->db->bind(":name", $data['name']);
        $this->db->bind(":lecture", $data['lecture']);
        $this->db->bind(":description", $data['description']);
        $this->db->bind(":mitra_type_id", $data['type']);

        $image = controller::saveFile('storage/image/', $file['image'], '');
        $mou = controller::saveFile('storage/mou/', $file['mou'], '');

        $this->db->bind(":image", $image);
        $this->db->bind(":mou_file", $mou);
        $res = $this->db->execute();
        if (is_null($res)) {
            return 'Berhasil Tambah Data';
        }else{
            return 'Gagal Tambah Data';
        }
    }

    public function getByID($id)
    {
        $queryMitra = "SELECT m.id, m.name, m.lecture, m.mou_file, m.description, m.image, tm.name as type_name, tm.id as type_id
                      FROM mitra m
                      LEFT JOIN type_mitra tm ON m.mitra_type_id = tm.id WHERE m.id = :id";
        $this->db->query($queryMitra);
        $this->db->bind(':id', $id);
        $mitras = $this->db->single();

        $groupedMitras = [];
        if ($mitras) {
            $groupId = $mitras['id'];
            $groupedMitras[$groupId] = $mitras;
            $groupedMitras[$groupId]['type'] = [];

            // Mengambil jenis mitra dari hasil query
            $groupedMitras[$groupId]['type'][] = [
                'type_id' => $mitras['type_id'],
                'type_name' => $mitras['type_name']
            ];
            unset($groupedMitras[$groupId]['type_id']);
            unset($groupedMitras[$groupId]['type_name']);
        }

        return ['mitras' => array_values($groupedMitras)];
    }




    public function show()
    {
        $queryTypes = "SELECT id, name FROM type_mitra";
        $this->db->query($queryTypes);
        $types = $this->db->resultSet();

        $queryMitra = "SELECT m.id, m.name, m.lecture, m.mou_file, m.created_at, tm.name as type_name, tm.id as type_id
                      FROM mitra m
                      LEFT JOIN type_mitra tm ON m.mitra_type_id = tm.id";
        $this->db->query($queryMitra);
        $mitras = $this->db->resultSet();

        $groupedMitras = [];
        foreach ($mitras as $mitra) {
            $groupId = $mitra['id'];
            if (!isset($groupedMitras[$groupId])) {
                $groupedMitras[$groupId] = $mitra;
                $groupedMitras[$groupId]['type'] = [];
            }
            $groupedMitras[$groupId]['type'][] = [
                'type_id' => $mitra['type_id'],
                'type_name' => $mitra['type_name']
            ];
            unset($groupedMitras[$groupId]['type_id']);
            unset($groupedMitras[$groupId]['type_name']);
        }

        return ['types' => $types, 'mitras' => array_values($groupedMitras)];
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

            // Delete file if it exists
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
        $oldFile = $oldData["mitras"][0]["mou_file"];
        $oldImage = $oldData["mitras"][0]["image"];

        $query = "UPDATE $this->table SET 
                    name = :name, 
                    lecture = :lecture, 
                    mitra_type_id = :type, 
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
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':lecture', $data['lecture']);
        $this->db->bind(':type', $data['type']);
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
        }else{
            return 'Gagal Update Data';
        }

    }
}
