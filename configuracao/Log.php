<?php

trait Log {

    public function log() {
        $socket = fsockopen('udp://pool.ntp.br', 123, $err_no, $err_str, 1);
        if ($socket) {
            if (fwrite($socket, chr(bindec('00' . sprintf('%03d', decbin(3)) . '011')) . str_repeat(chr(0x0), 39) . pack('N', time()) . pack("N", 0))) {
                stream_set_timeout($socket, 1);
                $unpack0 = unpack("N12", fread($socket, 48));
                $data = date('Y-m-d H:i:s', $unpack0[7]);
            }else{
                $data = date('d-m-Y');
                $data .= ' '.date('H:i:s');
            }
            fclose($socket);
        }else{
            $data = date('d-m-Y');
            $data .= ' '.date('H:i:s'); 
        }
        Logger::configure('configuracao/logsConfig.php');
        $logger = Logger::getLogger("main");
        $logger->info($data . " " . $_SERVER["REMOTE_ADDR"] . " " . $_SESSION["login"] . " SQL...");
    }
}
