<?php

class Product{
    public $name;
    public $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function &getTestData(array &$data = [], $flag){
        return 'test product data';
    }
}

$reflector = new ReflectionClass('Product');

//general reflection info
$reflectionInfo = Reflection::export($reflector, true);

//lets write own code for class and metods reserching
class ReflectionUtils{
    public static function getClassInfo(ReflectionClass $class){
        $info = "";
        $name = $class->getName();
        if($class->isUserDefined()){
            $info .= "class {$name} is declarated by user</br>";
        }
        if($class->isInstantiable()){
            $info .= "we can create instance of class {$name}</br>";
        }else{
            $info .=" class {name} isn't instantible</br>";
        }
        if($class->isInternal()){
            $info .= "{name} is internal class</br>";
        }
        if($class->isInterface()){
            $info .= "{name} is interface</br>";
        }
        if($class->isAbstract()){
            $info .= "class {name} is abstract</br>";
        }
        if($class->isTrait()){
            $info .= "class {name} is trait</br>";
        }
        if($class->isFinal()){
            $info .= "class {name} is final</br>";
        }

        return $info;
    }


    public static function getMethodsInfo(ReflectionClass $class ){
        $output = "";
        foreach ($class->getMethods() as $k=> $method){
            $output .= "method #{$k}</br>".self::getMethodInfo($method)."</br>";
        }
        return $output;
    }
    public static function getMethodInfo(ReflectionMethod $method){
        $info = "";
        if($method->getParameters()){
            $info .= "{$method->getName()} has {$method->getNumberOfParameters()} parameters</br>";
        }
        if($method->isUserDefined()){
            $info .="{$method->getName()} is defined by user</br>";
        }
        if($method->isPublic()){
            $info .= "{$method->getName()} is public</br>";
        }
        if($method->isProtected()){
            $info .= "{$method->getName()} is protected</br>";
        }
        if($method->isPrivate()){
            $info .= "{$method->getName()} is private</br>";
        }
        if($method->isStatic()){
            $info .= "{$method->getName()} is static</br>";
        }
        if($method->isConstructor()){
            $info .= "{$method->getName()} is constructor</br>";
        }
        if($method->returnsReference()){
            $info .= "{$method->getName()} returns reference</br>";
        }
        if($method->isFinal()){
            $info .= "{$method->getName()} is final";
        }

        return $info;
    }

    public static function getClassSourceCode(ReflectionClass $class){
        $linesArray = file($class->getFileName());
        $firstLine = $class->getStartLine();
        $length = $class->getStartLine() - $class->getEndLine()+1;
        $classCode = implode(PHP_EOL, array_slice($linesArray, $firstLine, $length));
        return $classCode;
    }

    public static function getMetodSourceCode(ReflectionMethod $method){
        $linesArray = file($method->getFileName());
        $firstLine = $method->getStartLine();
        $length = $method->getEndLine()-$method->getStartLine()-1;
        $methodCode = implode(PHP_EOL, array_slice($linesArray, $firstLine, $length));
        return $methodCode;
    }

    public static function getArgumentsInfo(ReflectionMethod $method){
        $info = '';
        foreach ($method->getParameters() as $parameter){
            $info .= self::getArgumentInfo($parameter).'</br><hr></br>';
        }
        return $info;
    }
    public static function getArgumentInfo(ReflectionParameter $arg){
        $info = '';
        $name = $arg->getName();
        $info .= 'Name : '.$name.'</br>';
        if($arg->getClass()){
            $info .=', class: '.$arg->getClass().'</br>';
        }
        if($arg->isPassedByReference()){
            $info .= 'Passed by reference</br>';
        }
        if($arg->isDefaultValueAvailable()){
            $info .= 'has default value : '.$arg->getDefaultValue().'</br>';
        }
        if($arg->isOptional()){
            $info .= 'parameter is optional</br>';
        }
        if($arg->allowsNull()){
            $info .= 'parameter can be null</br>';
        }
        if($arg->isCallable()){
            $info .= 'parameter is callable</br>';
        }
        return $info;
    }
}


$methodInfo = new ReflectionMethod('Product', 'getTestData');

//print(ReflectionUtils::getClassSourceCode($reflector));
//print(ReflectionUtils::getClassInfo($reflector));

//print(ReflectionUtils::getMethodInfo($methodInfo));
//print(ReflectionUtils::getMethodsInfo($reflector));
//print(ReflectionUtils::getMetodSourceCode($methodInfo));

print(ReflectionUtils::getArgumentsInfo($methodInfo));






