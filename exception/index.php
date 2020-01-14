<?php

class XmlException extends \Exception{
    private $error;

    public function __construct(\LibXMLError $error)
    {
        $shortfile = basename($error->file);
        $message = $shortfile.", line ".$error->line.', column '.$error->column.', error: '.$error->message;
        $this->error = $error;
        parent::__construct($message, $error->code);

    }

}

class FileException extends \Exception{

}
class ConfException extends \Exception{

}


class Conf{
    private $file;
    private $xml;
    private $lastmatch;


    public function __construct(string $file)
    {
        if(! is_file($file)){
            throw new FileException('File '.$file.' not found');
        }

        $this->file = $file;
        $this->xml = simplexml_load_file($file, null, LIBXML_NOERROR );

        if(! is_object($this->xml)){

            throw new XmlException(libxml_get_last_error());
        }

        $matches = $this->xml->xpath('/conf');
        if(! count($matches)){
            throw new ConfException('config not found in xml');
        }


    }

    public function write(){
        if(!is_writable($this->file)) {
            throw new Exception('файл '.$this->file.' file isn\'t writable');
        }
        file_put_contents($this->file, $this->xml->saveXML().'\n');
    }

    public function get(string $str) {
        $matches = $this->xml->xpath("/conf/item[@name=\"{$str}\"]");

        if(count($matches)){
            $this->lastmatch = $matches[0];
            return $matches[0];
        }
        return null;
    }

    public function set(string $key, string $value){
        if(!is_null($this->get($key))){
            $this->lastmatch[0] = $value;
            return;
        };
        $this->xml->addChild('item', $value)->addAttribute('name', $key);
        $this->write();
    }

}
try {

    $conf = new Conf('conf.xml');

}catch (FileException $e){
    //file isn't exists or accessible
    die($e->__toString());
}catch (XmlException $e){
    //xml syntax error
    die($e->__toString());
}catch(Exception $e){
    //this code shouldn't be executed
    die($e->__toString());
}

//print_r($conf->get('user'));
//$conf->set('ssl', '0');
?>