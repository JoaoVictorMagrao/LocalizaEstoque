<?php
    function data_br($data) {
        $data_array = explode("-", $data);
        $data_string = $data_array[2] . "/" . $data_array[1] . "/" . $data_array[0];

        return $data_string;
    }

?>

