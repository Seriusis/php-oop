<?php

//declarationg two namespaces in the one file is for the conveniece,
//don't do this in production projects;

namespace main{
    class Debugger{
        public static function checkNamespace(){
            print_r('</br>');
            print_r('global namespace : '.__NAMESPACE__);
            print_r('</br>');
        }
    }

}

namespace main\debug{

    use main as app;

    class Debugger{
        public static function checkNamespace(){
            print_r('</br>');
            print_r('local namespace : '.__NAMESPACE__);
            print_r('</br>');
        }
    }

//call local method (relative path, absulute path, pseudonym)
    Debugger::checkNamespace();
    \main\debug\Debugger::checkNamespace();
    app\debug\Debugger::checkNamespace();


//call global namespace method
    \main\Debugger::checkNamespace();
    app\Debugger::checkNamespace();

}


