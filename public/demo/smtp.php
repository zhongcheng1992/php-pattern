<?php
class Smtp
{
    protected $server;
    protected $port;
    public $err;
    protected $timeout = 30;
    protected $to = array();
    protected $from;
    protected $subject;
    protected $body;
    protected $username_64 = '';
    protected $password_64 = '';

    protected $codes = [
        '220' => true,
        '250' => true,
        '334' => true,
        '235' => true,
        '535' => false,
        '354' => true,
        '530' => true,
    ];

    public function __construct($server, $port, $timeout = 2)
    {
        $this->server = $server;
        $this->port = $port;
        $this->timeout = $timeout;
    }
    public function send()
    {
        $this->fp = fsockopen($this->server, $this->port, $error, $errorStr, $this->timeout);
        if (!$this->fp) {
            echo "$errorStr ($error)<br />\n";
            exit;
        }
        $out = "HELO {$this->server}\r\n";
        $this->error(fgets($this->fp, 1280));
        fwrite($this->fp, $out);
        $this->error(fgets($this->fp, 128));
        if (!$this->prpareAuth()) {
            return false;
        }

        if (!$this->prepareFrom()) {
            return false;
        }

        if (!$this->prepareTo()) {echo 0;return false;}
        if (!$this->prepareMsg()) {echo 1;return false;}
        fclose($this->fp);
        return true;
    }

    public function auth($username, $password)
    {
        $this->username_64 = base64_encode($username);
        $this->password_64 = base64_encode($password);
    }

    private function prpareAuth()
    {
        $err = false;
        if (!empty($this->username_64) && !empty($this->password_64)) {
            $out = "auth login\r\n";
            fwrite($this->fp, $out);
            $err = $this->error(fgets($this->fp, 1280));
            fwrite($this->fp, $this->username_64 . "\r\n");
            $err = $this->error(fgets($this->fp, 1280));
            fwrite($this->fp, $this->password_64 . "\r\n");
            $err = $this->error(fgets($this->fp, 1280));
        }
        return $err;
    }

    private function error($response)
    {
        $code = substr($response, 0, 3);
        if (array_key_exists($code, $this->codes)) {
            if (!$this->codes[$code]) {
                $this->err = "$response";
                return false;
            }
        } else {
            $this->err = "$response";
            return false;
        }
        return true;
    }

    public function to($email)
    {
        array_push($this->to, $email);
    }

    public function prepareTo()
    {
        foreach ($this->to as $email) {
            $out = "RCPT TO:" . $email . "\r\n";
            fwrite($this->fp, $out);
            $err = $this->error(fgets($this->fp, 128));
        }
        return $err;
    }

    public function from($email)
    {
        $this->from = $email;
    }

    public function prepareFrom()
    {
        $out = "MAIL FROM:" . $this->from . "\r\n";
        fwrite($this->fp, $out);
        return $this->error(fgets($this->fp, 128));
    }

    public function subject($subject)
    {
        $this->subject = $subject;
    }
    public function body($body)
    {
        $this->body = $body;
    }

    public function prepareMsg()
    {
        $out = "DATA\r\n";
        fwrite($this->fp, $out);

        $out = "SUBJECT:$this->subject\r\n\r\n";
        fwrite($this->fp, $out);

        $out = "$this->body\r\n";
        fwrite($this->fp, $out);

        $out = ".\r\n";
        fwrite($this->fp, $out);
        return $this->error(fgets($this->fp, 128));

    }
}


$smtp = new Smtp("smtp.163.com", 25, 2);
$smtp->auth('fyibmsd', 'papghslyswfpsnrc');
$smtp->from('fyibmsd@163.com');
$smtp->to('fyibmsd@126.com');
$smtp->subject("subject");
$smtp->body("message");
$result = $smtp->send();
var_dump($result);
