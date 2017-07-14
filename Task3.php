<?php
switch ($_SERVER['REQUEST_METHOD']) {
    case 'HEAD': {
        if (file_exists($_REQUEST['file']))
        {
            header("Content-Length: ".filesize($_REQUEST['file']));
        }
        break;
    };
    case 'GET': {
        if (file_exists($_REQUEST['file']))
        {
            $fp = fopen($_REQUEST['file'], 'r');
            while (!feof($fp)) {
                echo fgets($fp, filesize($_REQUEST['file']));
            }
            fclose($fp);
        } else {
            echo "Такого файла нет";
        }
        break;
    };
    case 'POST': {
        $fp = fopen($_REQUEST['file'], 'w+');
        if ($fp)
        {
            fwrite($fp, file_get_contents('php://input'));
        } else {
            echo "Ошибка при открытии файла";
        }
        fclose($fp);
        break;
    };
    case 'DELETE': {
        unlink($_REQUEST['file']);
        break;
    };
    case 'PATCH': {
        if (file_exists($_REQUEST['file']))
        {
            $fp = fopen($_REQUEST['file'], 'a');
            fwrite($fp, file_get_contents('php://input'));
            fclose($fp);
        } else {
            echo "Такого файла нет";
        }
        break;
    }
}