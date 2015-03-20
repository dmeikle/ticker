<?php

namespace Gossamer\Sockets\Ticker;

use Gossamer\Sockets\Ticker\RoomList;
use Gossamer\Sockets\Ticker\Room;

class Server {
    
    private $host;
    
    private $port;
        
    private $clients;
    
    private $concierge;
    
    public function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
        $this->concierge = new Concierge();
    }
    
    
    public function execute() {        
        //Create TCP/IP sream socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        //reuseable port
        socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

        //bind socket to specified host
        socket_bind($socket, 0, $this->port);

        //listen to port
        socket_listen($socket);

        //create & add listning socket to the list
        $this->clients = array($socket);
        
        //start endless loop, so that our script doesn't stop
        while (true) {
                //manage multiple connections
                $changed = $this->clients;
                
                $this->checkNewSockets($socket, $changed);
                
                $this->listenForMessages($changed);
                
        }
        // close the listening socket
        socket_close($sock);

    }
    
    private function checkNewSockets($socket, array &$list) {
        $null = NULL;
  
        //returns the socket resources in $changed array
        socket_select($list, $null, $null, 0, 10);
$roomId = 1;
        //check for new socket
        if (in_array($socket, $list)) {
            $socket_new = socket_accept($socket); //accpet new socket
            $this->clients[] = $socket_new; //add socket to client array

            $header = socket_read($socket_new, 1024); //read data sent by the socket
            $this->performHandshaking($header, $socket_new, $this->host, $this->port); //perform websocket handshake

            socket_getpeername($socket_new, $ip); //get ip address of connected socket
            //create the member instance
            $this->concierge->addSocket($ip, $socket_new);
            
            $response = $this->mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //prepare json data
            //$this->sendMessage($response); //notify all users about new connection
           // $this->concierge->notifyRooms($response);
            $this->concierge->sendMessage($roomId, $response);
           // $response = mask(json_encode(array('type'=>'system', 'message'=>print_r($socket_new, true)))); //prepare json data
            //send_message($response);
            //make room for new socket
            $found_socket = array_search($socket, $list);
            unset($list[$found_socket]);
        }
    }
    
    private function listenForMessages(array $list) {
        //loop through all connected sockets
        foreach ($list as $changed_socket) {
           
            //check for any incomming data
            while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
            {
               
                $received_text = $this->unmask($buf); //unmask data
               
                $tst_msg = json_decode($received_text); //json decode 
                if(is_null($tst_msg)) {
                    break;
                }
               
                $user_name = $tst_msg->name; //sender name
               
                $user_message = $tst_msg->message; //message text
                $user_color = $tst_msg->color; //color
                $roomId = $tst_msg->roomId;
               
                //prepare data to be sent to client
                $response_text = $this->mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'message'=>$user_message, 'color'=>$user_color)));
                //$this->sendMessage($response_text); //send data
                $this->concierge->sendMessage($roomId, $response_text);
                
                break 2; //exit this loop
            }

            $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
            if ($buf === false) { // check disconnected client
                // remove client for $clients array
                $found_socket = array_search($changed_socket, $this->clients);
                socket_getpeername($changed_socket, $ip);
                unset($this->clients[$found_socket]);
               
                $this->concierge->removeSocket($ip);
                //notify all users about disconnected connection
//                $response = $this->mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
//                $this->sendMessage($response);
            }
        }
    }
//    
//    private function sendMessage($msg)
//    {
//            foreach($this->clients as $changed_socket)
//            {
//                    @socket_write($changed_socket,$msg,strlen($msg));
//            }
//            return true;
//    }
//    
//    
    //Unmask incoming framed message
    private function unmask($text) {
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}
	elseif($length == 127) {
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}
	else {
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
    }

    //Encode message for transfer to client.
    private function mask($text)
    {
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
	return $header.$text;
    }

    //handshake new client.
    private function performHandshaking($receved_header,$client_conn, $host, $port)
    {
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	$secKey = $headers['Sec-WebSocket-Key'];
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
    }
}