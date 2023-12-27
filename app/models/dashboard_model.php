<?php
class dashboard_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function dashboard()
    {
        // user role mahasiswa
        $mahasiswaQuery = "SELECT COUNT(*) FROM users WHERE role = 'mahasiswa'";
        $this->db->query($mahasiswaQuery);
        $countMahasiswa = $this->db->single();

        // user role admin
        $adminQuery = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
        $this->db->query($adminQuery);
        $countAdmin = $this->db->single();

        // tb magang_penelitian
        $penelitianQuery = "SELECT COUNT(*) FROM `magang_penelitian`";
        $this->db->query($penelitianQuery);
        $countPenelitian = $this->db->single();

        // tb magang_partnership
        $partnershipQuery = "SELECT COUNT(*) FROM `magang_partnership`";
        $this->db->query($partnershipQuery);
        $countPartnership = $this->db->single();

        // tb magang_mandiri
        $mandiriQuery = "SELECT COUNT(*) FROM `magang_mandiri`";
        $this->db->query($mandiriQuery);
        $countMandiri = $this->db->single();

        return [
            'mahasiswa' => $countMahasiswa,
            'admin' => $countAdmin,
            'penelitian' => $countPenelitian,
            'partnership' => $countPartnership,
            'mandiri' => $countMandiri
        ];
    }
}
