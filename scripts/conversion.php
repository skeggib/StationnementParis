<?php

/**
 * Transforme des coordonnées GPS WGS84 en coordonnées ETRS89 en utilisant une homographie.
 * Cette fonction est adaptée aux coordonnées GPS se situant dans la ville de Paris uniquement, sa
 * précision n'est pas assurée pour le reste du monde.
 * @param lon La longitude.
 * @param lat La latitude.
 * @return array Un tableau contenant la composante E et N des coordonnées ETRS89.
 */
function WGS84_to_ETRS89($lon, $lat)
{
    $h00 = 1.36316602235241e-002;
    $h01 = 1.61524100583475e-002;
    $h02 = -1.24111553960781e-001;
    
    $h10 = -1.32787075851008e-003;
    $h11 = 3.13217114186788e-002;
    $h12 = -9.91547672487486e-001;
    
    $h20 = 2.91417287436729e-011;
    $h21 = 3.73828814778654e-009;
    $h22 = 2.65352435255837e-009;

    $r_x = $h00 * $lon + $h01 * $lat + $h02;
    $r_y = $h10 * $lon + $h11 * $lat + $h12;
    $div = $h20 * $lon + $h21 * $lat + $h22;

    $x_etrs = $r_x / $div;
    $y_etrs = $r_y / $div;

    return array($x_etrs, $y_etrs);
}

?>