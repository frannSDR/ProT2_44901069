<?php

//* FUNCION: convertir fecha/hora a texto legible como "Hace 2 horas"
// ejemplo: si un usuario se conecto el "2025-06-29 14:30:00" → "Hace 2 horas"
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime)
    {
        // si no hay fecha, devolvemos "Nunca"
        if (!$datetime) {
            return 'Nunca';
        }

        // calculamos cuantos segundos han pasado desde esa fecha hasta ahora
        // time() = segundos actuales, strtotime() = convierte fecha a segundos
        $time = time() - strtotime($datetime);

        // dependiendo de cuanto tiempo paso, devolvemos diferentes formatos:

        if ($time < 60) return 'Hace menos de 1 min';              // 0-59 segundos
        if ($time < 3600) return 'Hace ' . floor($time / 60) . ' min';     // 1-59 minutos
        if ($time < 86400) return 'Hace ' . floor($time / 3600) . ' hrs';  // 1-23 horas
        if ($time < 2592000) return 'Hace ' . floor($time / 86400) . ' días'; // 1-29 dias

        // si paso más de un mes, mostramos la fecha completa en formato DD/MM/YYYY
        return date('d/m/Y', strtotime($datetime));
    }
}

//* FUNCION: formatear cualquier fecha a un formato especifico
// Ejemplo: "2024-06-29 14:30:00" → "29/06/2024" o "29-06-24", etc.
if (!function_exists('format_date')) {
    function format_date($date, $format = 'd/m/Y')
    {
        // si no hay fecha, devolvemos un guión "-"
        if (!$date) return '-';

        // convertimos la fecha al formato que queramos
        return date($format, strtotime($date));
    }
}

//* FUNCION: Generar avatar de usuario (imagen o iniciales)
// Si el usuario tiene foto → muestra la foto
// Si NO tiene foto → muestra sus iniciales en un círculo colorido
if (!function_exists('user_avatar')) {
    function user_avatar($user_img, $nickname, $size = 40)
    {
        if (!empty($user_img)) {
            return '<img src="' . base_url('uploads/avatars/' . $user_img) . '" alt="Avatar" style="width: ' . $size . 'px; height: ' . $size . 'px; object-fit: cover; border-radius: 50%;">';
        } else {
            // tomamos las primeras 2 letras del nickname y las ponemos en mayusculas
            // ejemplo: "fran" → "FR"
            $initials = strtoupper(substr($nickname, 0, 2));

            return '<div class="avatar-placeholder" style="width: ' . $size . 'px; height: ' . $size . 'px;">' . $initials . '</div>';
        }
    }
}
