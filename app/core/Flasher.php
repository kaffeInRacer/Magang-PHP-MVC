<?php

class Flasher
{

    public static function setMessage($pesan, $type)
    {

        $_SESSION['msg'] = [
            'pesan' => $pesan,
            'type'  => $type
        ];
    }

    public static function Message()
    {
        if (isset($_SESSION['msg'])) {
            echo '<div class="justify-content-center align-items-center alert alert-' . $_SESSION['msg']['type'] . ' fade show" role="alert">
                    <strong>' . $_SESSION['msg']['pesan'] . '</strong>
                  </div>';

            unset($_SESSION['msg']);
        }
    }
}
