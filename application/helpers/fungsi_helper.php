<?php

function not_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('user_name')) {
        redirect('auth');
    }
}
function login()
{
    $ci = get_instance();
    if ($ci->session->userdata('user_name')) {
        redirect('dashboard');
    }
}

function userData()
{
    $ci = get_instance();
    $result['karyawan'] = $ci->db->get_where('karyawan', ['user_name' =>
    $ci->session->userdata('user_name')])->row_array();
    return $result;
}

function check_admin()
{
    $ci = get_instance();
    $roleId = $ci->session->userdata('level');
    if ($roleId != 1) {
        redirect('auth/blocked');
    }
}

function formatRupiah($angka)
{
    return "Rp " . number_format($angka, 0, ",", ".");
}

function bulan($bln)
{
    $bulan = $bln;
    switch ($bulan) {
        case 1:
            $bulan = "Januari";
            break;
        case 2:
            $bulan = "Februari";
            break;
        case 3:
            $bulan = "Maret";
            break;
        case 4:
            $bulan = "April";
            break;
        case 5:
            $bulan = "Mei";
            break;
        case 6:
            $bulan = "Juni";
            break;
        case 7:
            $bulan = "Juli";
            break;
        case 8:
            $bulan = "Agustus";
            break;
        case 9:
            $bulan = "September";
            break;
        case 10:
            $bulan = "Oktober";
            break;
        case 11:
            $bulan = "November";
            break;
        case 12:
            $bulan = "Desember";
            break;
    }
    return $bulan;
}
