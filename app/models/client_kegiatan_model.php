<?php
class client_kegiatan_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function show()
    {
        $query = "SELECT 
            CASE
                WHEN fi.partnership_id IS NOT NULL THEN 'partnership'
                WHEN fi.penelitian_id IS NOT NULL THEN 'penelitian'
                WHEN fi.mandiri_id IS NOT NULL THEN 'mandiri'
                ELSE NULL 
            END as type,
            CASE
                WHEN fi.partnership_id IS NOT NULL THEN mp.image 
                WHEN fi.penelitian_id IS NOT NULL THEN pen.image 
                WHEN fi.mandiri_id IS NOT NULL THEN 'storage/image/upi.png'
                ELSE NULL 
            END as image,
            CASE
                WHEN fi.partnership_id IS NOT NULL THEN mp.title 
                WHEN fi.penelitian_id IS NOT NULL THEN pen.title 
                WHEN fi.mandiri_id IS NOT NULL THEN man.mitra
                ELSE NULL 
            END as title,
            CASE
                WHEN fi.partnership_id IS NOT NULL THEN '' 
                WHEN fi.penelitian_id IS NOT NULL THEN pen.author 
                WHEN fi.mandiri_id IS NOT NULL THEN man.job 
                ELSE NULL 
            END as author,
            CASE
                WHEN fi.partnership_id IS NOT NULL THEN mp.address 
                WHEN fi.penelitian_id IS NOT NULL THEN 'Jl. Pendidikan No.15, Cibiru Wetan, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40625'
                ELSE NULL 
            END as address,
            CASE
                WHEN fi.partnership_id IS NOT NULL THEN mp.description 
                WHEN fi.penelitian_id IS NOT NULL THEN pen.description 
                ELSE NULL 
            END as description
        FROM 
            following_internships fi 
        JOIN 
            users u ON fi.user_id = u.id 
        LEFT JOIN 
            magang_partnership mp ON fi.partnership_id = mp.id 
        LEFT JOIN 
            magang_penelitian pen ON fi.penelitian_id = pen.id 
        LEFT JOIN 
            magang_mandiri man ON fi.mandiri_id = man.id
        WHERE 
            u.id = :id
        ";

        $this->db->query($query);
        $this->db->bind(':id', $_SESSION['user']['id']);
        $result = $this->db->resultSet();

        return $result;
    }
}
