<?php /* Eden_Class */
if (!class_exists('Eden_Class')) {
    class Eden_Class
    {
        const DEBUG = 'DEBUG %s:';
        const INSTANCE = 0;
        private static $_instances = array();

        public static function i()
        {
            if (static::INSTANCE === 1) {
                return self::_getSingleton();
            }
            return self::_getMultiple();
        }

        public function __call($name, $args)
        {
            if (preg_match("/^[A-Z]/", $name)) {
                try {
                    return Eden_Route::i()->getClass($name, $args);
                } catch (Eden_Route_Error $e) {
                }
            }
            try {
                return Eden_Route::i()->getMethod()->call($this, $name, $args);
            } catch (Eden_Route_Error $e) {
                Eden_Error::i($e->getMessage())->trigger();
            }
        }

        public function __invoke()
        {
            if (func_num_args() == 0) {
                return $this;
            }
            $args = func_get_args();
            if (is_array($args[0])) {
                $args = $args[0];
            }
            $class = array_shift($args);
            if (strpos('Eden_', $class) !== 0) {
                $class = 'Eden_' . $class;
            }
            try {
                return Eden_Route::i()->getClass($class, $args);
            } catch (Eden_Route_Error $e) {
                Eden_Error::i($e->getMessage())->trigger();
            }
        }

        public function __toString()
        {
            return get_class($this);
        }

        public function callThis($method, array $args = array())
        {
            Eden_Error::i()->argument(1, 'string');
            return Eden_Route::i()->getMethod($this, $method, $args);
        }

        public function debug($variable = NULL, $next = NULL)
        {
            $class = get_class($this);
            if (is_null($variable)) {
                Eden_Debug::i()->output(sprintf(self::DEBUG, $class))->output($this);
                return $this;
            }
            if ($variable === true) {
                return Eden_Debug::i()->next($this, $next);
            }
            if (!is_string($variable)) {
                Eden_Debug::i()->output(Eden_Error::DEBUG_NOT_STRING);
                return $this;
            }
            if (isset($this->$variable)) {
                Eden_Debug::i()->output(sprintf(self::DEBUG, $class . '->' . $variable))->output($this->$variable);
                return $this;
            }
            $private = '_' . $variable;
            if (isset($this->$private)) {
                Eden_Debug::i()->output(sprintf(self::DEBUG, $class . '->' . $private))->output($this->$private);
                return $this;
            }
            Eden_Debug::i()->output(sprintf(Eden_Error::DEBUG_NOT_PROPERTY, $variable, $class));
            return $this;
        }

        public function each($callback)
        {
            Eden_Error::i()->argument(1, 'callable');
            return Eden_Loop::i()->iterate($this, $callback);
        }

        public function routeThis($route)
        {
            Eden_Error::i()->argument(1, 'string');
            if (func_num_args() == 1) {
                Eden_Route::i()->getClass()->route($route, $this);
                return $this;
            }
            Eden_Error::i()->argument(2, 'string', 'object');
            $args = func_get_args();
            $source = array_shift($args);
            $class = array_shift($args);
            $destination = NULL;
            if (count($args)) {
                $destination = array_shift($args);
            }
            Eden_Route::i()->getMethod()->route($this, $source, $class, $destination);
            return $this;
        }

        public function when($isTrue, $lines = 0)
        {
            if ($isTrue) {
                return $this;
            }
            return Eden_When::i($this, $lines);
        }

        protected static function _getMultiple($class = NULL)
        {
            if (is_null($class) && function_exists('get_called_class')) {
                $class = get_called_class();
            }
            $class = Eden_Route::i()->getClass()->getRoute($class);
            return self::_getInstance($class);
        }

        protected static function _getSingleton($class = NULL)
        {
            if (is_null($class) && function_exists('get_called_class')) {
                $class = get_called_class();
            }
            $class = Eden_Route::i()->getClass()->getRoute($class);
            if (!isset(self::$_instances[$class])) {
                self::$_instances[$class] = self::_getInstance($class);
            }
            return self::$_instances[$class];
        }

        private static function _getInstance($class)
        {
            $trace = debug_backtrace();
            $args = array();
            if (isset($trace[1]['args']) && count($trace[1]['args']) > 1) {
                $args = $trace[1]['args'];
                array_shift($args);
            } else if (isset($trace[2]['args']) && count($trace[2]['args']) > 0) {
                $args = $trace[2]['args'];
            }
            if (count($args) === 0 || !method_exists($class, '__construct')) {
                return new $class;
            }
            $reflect = new ReflectionClass($class);
            try {
                return $reflect->newInstanceArgs($args);
            } catch (Reflection_Exception $e) {
                Eden_Error::i()->setMessage(Eden_Error::REFLECTION_ERROR)->addVariable($class)->addVariable('new')->trigger();
            }
        }
    }
}
/* Eden_Error */
if (!class_exists('Eden_Error')) {
    class Eden_Error extends Exception
    {
        const REFLECTION_ERROR = 'Error creating Reflection Class: %s,Method: %s.';
        const INVALID_ARGUMENT = 'Argument %d in %s() was expecting %s,however %s was given.';
        const ARGUMENT = 'ARGUMENT';
        const LOGIC = 'LOGIC';
        const GENERAL = 'GENERAL';
        const CRITICAL = 'CRITICAL';
        const WARNING = 'WARNING';
        const ERROR = 'ERROR';
        const DEBUG = 'DEBUG';
        const INFORMATION = 'INFORMATION';
        const DEBUG_NOT_STRING = 'Debug was expecting a string';
        const DEBUG_NOT_PROPERTY = 'Debug: %s is not a property of %s';
        protected $_reporter = NULL;
        protected $_type = NULL;
        protected $_level = NULL;
        protected $_offset = 1;
        protected $_variables = array();
        protected $_trace = array();
        protected static $_argumentTest = true;

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }

        public function __construct($message = NULL, $code = 0)
        {
            $this->_type = self::LOGIC;
            $this->_level = self::ERROR;
            parent::__construct($message, $code);
        }

        public function addVariable($variable)
        {
            $this->_variables[] = $variable;
            return $this;
        }

        public function argument($index, $types)
        {
            if (!self::$_argumentTest) {
                return $this;
            }
            $trace = debug_backtrace();
            $trace = $trace[1];
            $types = func_get_args();
            $index = array_shift($types) - 1;
            if ($index < 0) {
                $index = 0;
            }
            if ($index >= count($trace['args'])) {
                return $this;
            }
            $argument = $trace['args'][$index];
            foreach ($types as $i => $type) {
                if ($this->_isValid($type, $argument)) {
                    return $this;
                }
            }
            $method = $trace['function'];
            if (isset($trace['class'])) {
                $method = $trace['class'] . '->' . $method;
            }
            $type = $this->_getType($argument);
            $this->setMessage(self::INVALID_ARGUMENT)->addVariable($index + 1)->addVariable($method)->addVariable(implode(' or ', $types))->addVariable($type)->setTypeLogic()->setTraceOffset(1)->trigger();
        }

        public function getLevel()
        {
            return $this->_level;
        }

        public function getRawTrace()
        {
            return $this->_trace;
        }

        public function getReporter()
        {
            return $this->_reporter;
        }

        public function getTraceOffset()
        {
            return $this->_offset;
        }

        public function getType()
        {
            return $this->_type;
        }

        public function getVariables()
        {
            return $this->_variables;
        }

        public function noArgTest()
        {
            self::$_argumentTest = false;
            return $this;
        }

        public function setLevel($level)
        {
            $this->_level = $level;
            return $this;
        }

        public function setLevelDebug()
        {
            return $this->setLevel(self::DEBUG);
        }

        public function setLevelError()
        {
            return $this->setLevel(self::WARNING);
        }

        public function setLevelInformation()
        {
            return $this->setLevel(self::INFORMATION);
        }

        public function setLevelWarning()
        {
            return $this->setLevel(self::WARNING);
        }

        public function setMessage($message)
        {
            $this->message = $message;
            return $this;
        }

        public function setTraceOffset($offset)
        {
            $this->_offset = $offset;
            return $this;
        }

        public function setType($type)
        {
            $this->_type = $type;
            return $this;
        }

        public function setTypeArgument()
        {
            return $this->setType(self::ARGUMENT);
        }

        public function setTypeCritical()
        {
            return $this->setType(self::CRITICAL);
        }

        public function setTypeGeneral()
        {
            return $this->setType(self::GENERAL);
        }

        public function setTypeLogic()
        {
            return $this->setType(self::CRITICAL);
        }

        public function trigger()
        {
            $this->_trace = debug_backtrace();
            $this->_reporter = get_class($this);
            if (isset($this->_trace[$this->_offset]['class'])) {
                $this->_reporter = $this->_trace[$this->_offset]['class'];
            }
            if (isset($this->_trace[$this->_offset]['file'])) {
                $this->file = $this->_trace[$this->_offset]['file'];
            }
            if (isset($this->_trace[$this->_offset]['line'])) {
                $this->line = $this->_trace[$this->_offset]['line'];
            }
            if (!empty($this->_variables)) {
                $this->message = vsprintf($this->message, $this->_variables);
                $this->_variables = array();
            }
            throw $this;
        }

        public function vargument($method, $args, $index, $types)
        {
            if (!self::$_argumentTest) {
                return $this;
            }
            $trace = debug_backtrace();
            $trace = $trace[1];
            $types = func_get_args();
            $method = array_shift($types);
            $args = array_shift($types);
            $index = array_shift($types) - 1;
            if ($index < 0) {
                $index = 0;
            }
            if ($index >= count($args)) {
                return $this;
            }
            $argument = $args[$index];
            foreach ($types as $i => $type) {
                if ($this->_isValid($type, $argument)) {
                    return $this;
                }
            }
            $method = $trace['class'] . '->' . $method;
            $type = $this->_getType($argument);
            $this->setMessage(self::INVALID_ARGUMENT)->addVariable($index + 1)->addVariable($method)->addVariable(implode(' or ', $types))->addVariable($type)->setTypeLogic()->setTraceOffset(1)->trigger();
        }

        protected function _isCreditCard($value)
        {
            return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]' . '{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-' . '5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/', $value);
        }

        protected function _isEmail($value)
        {
            return preg_match('/^(?:(?:(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|\x5c(?=[@,"\[\]' . '\x5c\x00-\x20\x7f-\xff]))(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]' . '\x5c\x00-\x20\x7f-\xff]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff])|\.(?=[^\.])){1,62' . '}(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff])|' . '[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]{1,2})|"(?:[^"]|(?<=\x5c)"){1,62}")@(?:(?!.{64})' . '(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9]\.?)+\.(?:xn--[a-zA-Z0-9]' . '+|[a-zA-Z]{2,6})|\[(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])(?:\.(?:[0-1]?\d?\d|2[0-4]\d|25' . '[0-5])){3}\])$/', $value);
        }

        protected function _isHex($value)
        {
            return preg_match("/^[0-9a-fA-F]{6}$/", $value);
        }

        protected function _isHtml($value)
        {
            return preg_match("/<\/?\w+((\s+(\w|\w[\w-]*\w)(\s*=\s*" . "(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i", $value);
        }

        protected function _isUrl($value)
        {
            return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0' . '-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $value);
        }

        public function _alphaNum($value)
        {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        }

        public function _alphaNumScore($value)
        {
            return preg_match('/^[a-zA-Z0-9_]+$/', $value);
        }

        public function _alphaNumHyphen($value)
        {
            return preg_match('/^[a-zA-Z0-9-]+$/', $value);
        }

        public function _alphaNumLine($value)
        {
            return preg_match('/^[a-zA-Z0-9-_]+$/', $value);
        }

        protected function _isValid($type, $data)
        {
            $type = $this->_getTypeName($type);
            switch ($type) {
                case 'number':
                    return is_numeric($data);
                case 'int':
                    return is_numeric($data) && strpos((string)$data, '.') === false;
                case 'float':
                    return is_numeric($data) && strpos((string)$data, '.') !== false;
                case 'file':
                    return is_string($data) && file_exists($data);
                case 'folder':
                    return is_string($data) && is_dir($data);
                case 'email':
                    return is_string($data) && $this->_isEmail($data);
                case 'url':
                    return is_string($data) && $this->_isUrl($data);
                case 'html':
                    return is_string($data) && $this->_isHtml($data);
                case 'cc':
                    return (is_string($data) || is_int($data)) && $this->_isCreditCard($data);
                case 'hex':
                    return is_string($data) && $this->_isHex($data);
                case 'alphanum':
                    return is_string($data) && $this->_alphaNum($data);
                case 'alphanumscore':
                    return is_string($data) && $this->_alphaNumScore($data);
                case 'alphanumhyphen':
                    return is_string($data) && $this->_alphaNumHyphen($data);
                case 'alphanumline':
                    return is_string($data) && $this->_alphaNumLine($data);
                default:
                    break;
            }
            $method = 'is_' . $type;
            if (function_exists($method)) {
                return $method($data);
            }
            if (class_exists($type)) {
                return $data instanceof $type;
            }
            return true;
        }

        private function _getType($data)
        {
            if (is_string($data)) {
                return "'" . $data . "'";
            }
            if (is_numeric($data)) {
                return $data;
            }
            if (is_array($data)) {
                return 'Array';
            }
            if (is_bool($data)) {
                return $data ? 'true' : 'false';
            }
            if (is_object($data)) {
                return get_class($data);
            }
            if (is_null($data)) {
                return 'null';
            }
            return 'unknown';
        }

        private function _getTypeName($data)
        {
            if (is_string($data)) {
                return $data;
            }
            if (is_numeric($data)) {
                return 'numeric';
            }
            if (is_array($data)) {
                return 'array';
            }
            if (is_bool($data)) {
                return 'bool';
            }
            if (is_object($data)) {
                return get_class($data);
            }
            if (is_null($data)) {
                return 'null';
            }
        }
    }
}
/* Eden_Event */
if (!class_exists('Eden_Event')) {
    class Eden_Event extends Eden_Class
    {
        protected $_observers = array();

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function listen($event, $instance, $method = NULL, $important = false)
        {
            $error = Eden_Event_Error::i()->argument(1, 'string')->argument(2, 'object', 'string', 'callable')->argument(3, 'null', 'string', 'bool')->argument(4, 'bool');
            if (is_bool($method)) {
                $important = $method;
                $method = NULL;
            }
            $id = $this->_getId($instance, $method);
            $callable = $this->_getCallable($instance, $method);
            $observer = array($event, $id, $callable);
            if ($important) {
                array_unshift($this->_observers, $observer);
                return $this;
            }
            $this->_observers[] = $observer;
            return $this;
        }

        public function trigger($event = NULL)
        {
            Eden_Event_Error::i()->argument(1, 'string', 'null');
            if (is_null($event)) {
                $trace = debug_backtrace();
                $event = $trace[1]['function'];
            }
            $args = func_get_args();
            $event = array_shift($args);
            array_unshift($args, $this, $event);
            foreach ($this->_observers as $observer) {
                if ($event == $observer[0] && call_user_func_array($observer[2], $args) === false) {
                    break;
                }
            }
            return $this;
        }

        public function unlisten($event, $instance = NULL, $method = NULL)
        {
            Eden_Event_Error::i()->argument(1, 'string', 'null')->argument(2, 'object', 'string', 'null')->argument(3, 'string', 'null');
            if (is_null($event) && is_null($instance)) {
                $this->_observers = array();
                return $this;
            }
            $id = $this->_getId($instance, $method);
            if ($id === false) {
                return false;
            }
            foreach ($this->_observers as $i => $observer) {
                if (!is_null($event) && $event != $observer[0]) {
                    continue;
                }
                if ($id == $observer[1] && is_array($observer[2]) && $method != $observer[2][1]) {
                    continue;
                }
                if ($id != $observer[1]) {
                    continue;
                }
                unset($this->_observers[$i]);
            }
            return $this;
        }

        protected function _getCallable($instance, $method = NULL)
        {
            if (class_exists('Closure') && $instance instanceof Closure) {
                return $instance;
            }
            if (is_object($instance)) {
                return array($instance, $method);
            }
            if (is_string($instance) && is_string($method)) {
                return $instance . '::' . $method;
            }
            if (is_string($instance)) {
                return $instance;
            }
            return NULL;
        }

        protected function _getId($instance, $method = NULL)
        {
            if (is_object($instance)) {
                return spl_object_hash($instance);
            }
            if (is_string($instance) && is_string($method)) {
                return $instance . '::' . $method;
            }
            if (is_string($instance)) {
                return $instance;
            }
            return false;
        }
    }

    class Eden_Event_Error extends Eden_Error
    {
        const NO_METHOD = 'Instance %s was passed but,no callable method was passed in listen().';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Error_Event */
if (!class_exists('Eden_Error_Event')) {
    class Eden_Error_Event extends Eden_Event
    {
        const PHP = 'PHP';
        const UNKNOWN = 'UNKNOWN';
        const WARNING = 'WARNING';
        const ERROR = 'ERROR';

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function errorHandler($errno, $errstr, $errfile, $errline)
        {
            switch ($errno) {
                case E_NOTICE:
                case E_USER_NOTICE:
                case E_WARNING:
                case E_USER_WARNING:
                    $level = self::WARNING;
                    break;
                case E_ERROR:
                case E_USER_ERROR:
                default:
                    $level = self::ERROR;
                    break;
            }
            $type = self::PHP;
            $trace = debug_backtrace();
            $class = self::UNKNOWN;
            if (count($trace) > 1) {
                $class = $trace[1]['function'] . '()';
                if (isset($trace[1]['class'])) {
                    $class = $trace[1]['class'] . '->' . $class;
                }
            }
            $this->trigger('error', $type, $level, $class, $errfile, $errline, $errstr, $trace, 1);
            return true;
        }

        public function exceptionHandler(Exception $e)
        {
            $type = Eden_Error::LOGIC;
            $level = Eden_Error::ERROR;
            $offset = 1;
            $reporter = get_class($e);
            $trace = $e->getTrace();
            $message = $e->getMessage();
            if ($e instanceof Eden_Error) {
                $trace = $e->getRawTrace();
                $type = $e->getType();
                $level = $e->getLevel();
                $offset = $e->getTraceOffset();
                $reporter = $e->getReporter();
            }
            $this->trigger('exception', $type, $level, $reporter, $e->getFile(), $e->getLine(), $message, $trace, $offset);
        }

        public function releaseErrorHandler()
        {
            restore_error_handler();
            return $this;
        }

        public function releaseExceptionHandler()
        {
            restore_exception_handler();
            return $this;
        }

        public function setErrorHandler()
        {
            set_error_handler(array($this, 'errorHandler'));
            return $this;
        }

        public function setExceptionHandler()
        {
            set_exception_handler(array($this, 'exceptionHandler'));
            return $this;
        }

        public function setReporting($type)
        {
            error_reporting($type);
            return $this;
        }
    }
}
/* Eden_Route_Error */
if (!class_exists('Eden_Route_Error')) {
    class Eden_Route_Error extends Eden_Error
    {
        const CLASS_NOT_EXISTS = 'Invalid class call: %s->%s().Class does not exist.';
        const METHOD_NOT_EXISTS = 'Invalid class call: %s->%s().Method does not exist.';
        const STATIC_ERROR = 'Invalid class call: %s::%s().';
        const FUNCTION_ERROR = 'Invalid function run: %s().';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Route_Class */
if (!class_exists('Eden_Route_Class')) {
    class Eden_Route_Class extends Eden_Class
    {
        protected static $_instance = NULL;
        protected $_route = array();

        public static function i()
        {
            $class = __CLASS__;
            if (is_null(self::$_instance)) {
                self::$_instance = new $class();
            }
            return self::$_instance;
        }

        public function call($class)
        {
            Eden_Route_Error::i()->argument(1, 'string');
            $args = func_get_args();
            $class = array_shift($args);
            return $this->callArray($class, $args);
        }

        public function callArray($class, array $args = array())
        {
            Eden_Route_Error::i()->argument(1, 'string');
            $route = $this->getRoute($class);
            if (is_object($route)) {
                return $route;
            }
            $reflect = new ReflectionClass($route);
            if (method_exists($route, 'i')) {
                $declared = $reflect->getMethod('i')->getDeclaringClass()->getName();
                return Eden_Route_Method::i()->callStatic($class, 'i', $args);
            }
            return $reflect->newInstanceArgs($args);
        }

        public function getRoute($route)
        {
            Eden_Route_Error::i()->argument(1, 'string');
            if ($this->isRoute($route)) {
                return $this->_route[strtolower($route)];
            }
            return $route;
        }

        public function getRoutes()
        {
            return $this->_route;
        }

        public function isRoute($route)
        {
            return isset($this->_route[strtolower($route)]);
        }

        public function release($route)
        {
            if ($this->isRoute($route)) {
                unset($this->_route[strtolower($route)]);
            }
            return $this;
        }

        public function route($route, $class)
        {
            Eden_Route_Error::i()->argument(1, 'string', 'object')->argument(2, 'string', 'object');
            if (is_object($route)) {
                $route = get_class($route);
            }
            if (is_string($class)) {
                $class = $this->getRoute($class);
            }
            $this->_route[strtolower($route)] = $class;
            return $this;
        }
    }
}
/* Eden_Route_Method */
if (!class_exists('Eden_Route_Method')) {
    class Eden_Route_Method extends Eden_Class
    {
        protected static $_instance = NULL;
        protected $_route = array();

        public static function i()
        {
            $class = __CLASS__;
            if (is_null(self::$_instance)) {
                self::$_instance = new $class();
            }
            return self::$_instance;
        }

        public function call($class, $method, array $args = array())
        {
            Eden_Route_Error::i()->argument(1, 'string', 'object')->argument(2, 'string');
            $instance = NULL;
            if (is_object($class)) {
                $instance = $class;
                $class = get_class($class);
            }
            $classRoute = Eden_Route_Class::i();
            $isClassRoute = $classRoute->isRoute($class);
            $isMethodRoute = $this->isRoute($class, $method);
            list($class, $method) = $this->getRoute($class, $method);
            if (!is_object($class) && !class_exists($class)) {
                Eden_Route_Error::i()->setMessage(Eden_Route_Error::CLASS_NOT_EXISTS)->addVariable($class)->addVariable($method)->trigger();
            }
            if (!$isClassRoute && !$isMethodRoute && !method_exists($class, $method)) {
                Eden_Route_Error::i()->setMessage(Eden_Route_Error::METHOD_NOT_EXISTS)->addVariable($class)->addVariable($method)->trigger();
            }
            if ($isClassRoute || !$instance) {
                $instance = $classRoute->call($class);
            }
            return call_user_func_array(array(&$instance, $method), $args);
        }

        public function callStatic($class, $method, array $args = array())
        {
            Eden_Route_Error::i()->argument(1, 'string', 'object')->argument(2, 'string');
            if (is_object($class)) {
                $class = get_class($class);
            }
            $isClassRoute = Eden_Route_Class::i()->isRoute($class);
            $isMethodRoute = $this->isRoute($class, $method);
            list($class, $method) = $this->getRoute($class, $method);
            if (!is_object($class) && !class_exists($class)) {
                Eden_Route_Error::i()->setMessage(Eden_Route_Error::CLASS_NOT_EXISTS)->addVariable($class)->addVariable($method)->trigger();
            }
            if (!$isClassRoute && !$isMethodRoute && !method_exists($class, $method)) {
                Eden_Route_Error::i()->setMessage(Eden_Route_Error::METHOD_NOT_EXISTS)->addVariable($class)->addVariable($method)->trigger();
            }
            if (is_object($class)) {
                $class = get_class($class);
            }
            return call_user_func_array($class . '::' . $method, $args);
        }

        public function getRoute($class, $method)
        {
            Eden_Route_Error::i()->argument(1, 'string')->argument(2, 'string');
            if ($this->isRoute(NULL, $method)) {
                return $this->_route[NULL][strtolower($method)];
            }
            $class = Eden_Route_Class::i()->getRoute($class);
            if ($this->isRoute($class, $method)) {
                return $this->_route[strtolower($class)][strtolower($method)];
            }
            return array($class, $method);
        }

        public function getRoutes()
        {
            return $this->_route;
        }

        public function isRoute($class, $method)
        {
            if (is_string($class)) {
                $class = strtolower($class);
            }
            return isset($this->_route[$class][strtolower($method)]);
        }

        public function release($class, $method)
        {
            if ($this->isRoute($class, $method)) {
                unset($this->_route[strtolower($class)][strtolower($method)]);
            }
            return $this;
        }

        public function route($source, $alias, $class, $method = NULL)
        {
            Eden_Route_Error::i()->argument(1, 'string', 'object', 'null')->argument(2, 'string')->argument(3, 'string', 'object')->argument(4, 'string');
            if (is_object($source)) {
                $source = get_class($source);
            }
            if (!is_string($method)) {
                $method = $alias;
            }
            $route = Eden_Route_Class::i();
            if (!is_null($source)) {
                $source = $route->getRoute($source);
                $source = strtolower($source);
            }
            if (is_string($class)) {
                $class = $route->getRoute($class);
            }
            $this->_route[$source][strtolower($alias)] = array($class, $method);
            return $this;
        }
    }
}
/* Eden_Route_Function */
if (!class_exists('Eden_Route_Function')) {
    class Eden_Route_Function extends Eden_Class
    {
        protected static $_instance = NULL;
        protected $_route = array();

        public static function i()
        {
            $class = __CLASS__;
            if (is_null(self::$_instance)) {
                self::$_instance = new $class();
            }
            return self::$_instance;
        }

        public function call($function)
        {
            Eden_Route_Error::i()->argument(1, 'string');
            $args = func_get_args();
            $function = array_shift($args);
            return $this->callArray($function, $args);
        }

        public function callArray($function, array $args = array())
        {
            Eden_Route_Error::i()->argument(1, 'string');
            $function = $this->getRoute($function);
            return call_user_func_array($function, $args);
        }

        public function getRoute($route)
        {
            Eden_Route_Error::i()->argument(1, 'string');
            if ($this->isRoute($route)) {
                return $this->_route[strtolower($route)];
            }
            return $route;
        }

        public function getRoutes()
        {
            return $this->_route;
        }

        public function isRoute($route)
        {
            return isset($this->_route[strtolower($route)]);
        }

        public function release($route)
        {
            if ($this->isRoute($route)) {
                unset($this->_route[strtolower($route)]);
            }
            return $this;
        }

        public function route($route, $function)
        {
            Eden_Route_Error::i()->argument(1, 'string')->argument(2, 'string');
            $function = $this->getRoute($function);
            $this->_route[strtolower($route)] = $function;
            return $this;
        }
    }
}
/* Eden_Route */
if (!class_exists('Eden_Route')) {
    class Eden_Route extends Eden_Class
    {
        protected static $_instance = NULL;

        public static function i()
        {
            $class = __CLASS__;
            if (is_null(self::$_instance)) {
                self::$_instance = new $class();
            }
            return self::$_instance;
        }

        public function getClass($class = NULL, array $args = array())
        {
            $route = Eden_Route_Class::i();
            if (is_null($class)) {
                return $route;
            }
            return $route->callArray($class, $args);
        }

        public function getFunction($function = NULL, array $args = array())
        {
            $route = Eden_Route_Function::i();
            if (is_null($function)) {
                return $route;
            }
            return $route->callArray($function, $args);
        }

        public function getMethod($class = NULL, $method = NULL, array $args = array())
        {
            $route = Eden_Route_Method::i();
            if (is_null($class) || is_null($method)) {
                return $route;
            }
            return $route->call($class, $method, $args);
        }
    }
}
/* Eden_When */
if (!class_exists('Eden_When')) {
    class Eden_When extends Eden_Class implements ArrayAccess, Iterator
    {
        protected $_scope = NULL;
        protected $_increment = 1;
        protected $_lines = 0;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($scope, $lines = 0)
        {
            $this->_scope = $scope;
            $this->_lines = $lines;
        }

        public function __call($name, $args)
        {
            if ($this->_lines > 0 && $this->_increment == $this->_lines) {
                return $this->_scope;
            }
            $this->_increment++;
            return $this;
        }

        public function current()
        {
            return $this->_scope->current();
        }

        public function key()
        {
            return $this->_scope->key();
        }

        public function next()
        {
            $this->_scope->next();
        }

        public function offsetExists($offset)
        {
            return $this->_scope->offsetExists($offset);
        }

        public function offsetGet($offset)
        {
            return $this->_scope->offsetGet($offset);
        }

        public function offsetSet($offset, $value)
        {
        }

        public function offsetUnset($offset)
        {
        }

        public function rewind()
        {
            $this->_scope->rewind();
        }

        public function valid()
        {
            return $this->_scope->valid();
        }
    }
}
/* Eden_Debug */
if (!class_exists('Eden_Debug')) {
    class Eden_Debug extends Eden_Class
    {
        protected $_scope = NULL;
        protected $_name = NULL;

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function __call($name, $args)
        {
            if (is_null($this->_scope)) {
                return parent::__call($name, $args);
            }
            $results = $this->_getResults($name, $args);
            $name = $this->_name;
            $scope = $this->_scope;
            $this->_name = NULL;
            $this->_scope = NULL;
            if ($name) {
                $scope->debug($name);
                return $results;
            }
            $class = get_class($scope);
            $this->output(sprintf(self::DEBUG, $class . '->' . $name))->output($results);
            return $results;
        }

        public function next($scope, $name = NULL)
        {
            Eden_Error::i()->argument(1, 'object')->argument(2, 'string', 'null');
            $this->_scope = $scope;
            $this->_name = $name;
            return $this;
        }

        public function output($variable)
        {
            if ($variable === true) {
                $variable = '*TRUE*';
            } else if ($variable === false) {
                $variable = '*FALSE*';
            } else if (is_null($variable)) {
                $variable = '*NULL*';
            }
            echo '<pre>' . print_r($variable, true) . '</pre>';
            return $this;
        }

        protected function _getResults($name, $args)
        {
            if (method_exists($this->_scope, $name)) {
                return call_user_func_array(array($this->_scope, $name), $args);
            }
            return $this->_scope->__call($name, $args);
        }
    }
}
/* Eden_Loop */
if (!class_exists('Eden_Loop')) {
    class Eden_Loop extends Eden_Class
    {
        protected $_scope = NULL;
        protected $_callback = NULL;

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function __call($name, $args)
        {
            if (is_null($this->_scope)) {
                return parent::__call($name, $args);
            }
            $results = $this->_getResults($name, $args);
            $loopable = is_scalar($results) ? array($results) : $results;
            foreach ($loopable as $key => $value) {
                if (call_user_func($this->_callback, $key, $value) === false) {
                    break;
                }
            }
            return $results;
        }

        public function iterate($scope, $callback)
        {
            Eden_Error::i()->argument(1, 'object')->argument(2, 'callable');
            $this->_scope = $scope;
            $this->_callback = $callback;
            return $this;
        }

        protected function _getResults($name, $args)
        {
            if (method_exists($this->_scope, $name)) {
                return call_user_func_array(array($this->_scope, $name), $args);
            }
            return $this->_scope->__call($name, $args);
        }
    }
}
/* Eden_Loader */
if (!class_exists('Eden_Loader')) {
    class Eden_Loader extends Eden_Class
    {
        protected $_root = array();

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function __construct($eden = true)
        {
            if ($eden) {
                $this->addRoot(realpath(dirname(__FILE__) . '/..'));
            }
        }

        public function __call($name, $args)
        {
            if (preg_match("/^[A-Z]/", $name)) {
                $this->load($name);
            }
            return parent::__call($name, $args);
        }

        public function addRoot($path)
        {
            array_unshift($this->_root, $path);
            return $this;
        }

        public function handler($class)
        {
            if (!is_string($class)) {
                return false;
            }
            $path = str_replace(array('_', '\\'), '/', $class);
            $path = '/' . strtolower($path);
            $path = str_replace('//', '/', $path);
            foreach ($this->_root as $root) {
                $file = $root . $path . '.php';
                if (file_exists($file) && require_once($file)) {
                    return true;
                }
            }
            return false;
        }

        public function load($class)
        {
            if (!class_exists($class)) {
                $this->handler($class);
            }
            return $this;
        }
    }
}
/* Eden_Type */
if (!class_exists('Eden_Type')) {
    class Eden_Type extends Eden_Class
    {
        public static function i($type = NULL)
        {
            if (func_num_args() > 1) {
                $type = func_get_args();
            }
            if (is_array($type)) {
                return Eden_Type_Array::i($type);
            }
            if (is_string($type)) {
                return Eden_Type_String::i($type);
            }
            return self::_getSingleton(__CLASS__);
        }

        public function getArray($array)
        {
            $args = func_get_args();
            if (count($args) > 1 || !is_array($array)) {
                $array = $args;
            }
            return Eden_Type_Array::i($array);
        }

        public function getString($string)
        {
            return Eden_Type_String::i($string);
        }
    }
}
/* Eden_Type_Abstract */
if (!class_exists('Eden_Type_Abstract')) {
    abstract class Eden_Type_Abstract extends Eden_Class
    {
        const PRE = 'pre';
        const POST = 'post';
        const REFERENCE = 'reference';
        protected $_data = NULL;
        protected $_original = NULL;

        public function __call($name, $args)
        {
            $type = $this->_getMethodType($name);
            if (!$type) {
                try {
                    return parent::__call($name, $args);
                } catch (Eden_Error $e) {
                    Eden_Type_Error::i($e->getMessage())->trigger();
                }
            }
            switch ($type) {
                case self::PRE:
                    array_unshift($args, $this->_data);
                    break;
                case self::POST:
                    array_push($args, $this->_data);
                    break;
                case self::REFERENCE:
                    call_user_func_array($name, array_merge(array(&$this->_data), $args));
                    return $this;
            }
            $result = call_user_func_array($name, $args);
            if (is_string($result)) {
                if ($this instanceof Eden_Type_String) {
                    $this->_data = $result;
                    return $this;
                }
                return Eden_Type_String::i($result);
            }
            if (is_array($result)) {
                if ($this instanceof Eden_Type_Array) {
                    $this->_data = $result;
                    return $this;
                }
                return Eden_Type_Array::i($result);
            }
            return $result;
        }

        public function __construct($data)
        {
            $this->_original = $this->_data = $data;
        }

        public function get($modified = true)
        {
            Eden_Type_Error::i()->argument(1, 'bool');
            return $modified ? $this->_data : $this->_original;
        }

        public function revert()
        {
            $this->_data = $this->_original;
            return $this;
        }

        public function set($value)
        {
            $this->_data = $value;
            return $this;
        }

        abstract protected function _getMethodType(&$name);
    }
}
/* Eden_Type_Error */
if (!class_exists('Eden_Type_Error')) {
    class Eden_Type_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Type_Array */
if (!class_exists('Eden_Type_Array')) {
    class Eden_Type_Array extends Eden_Type_Abstract implements ArrayAccess, Iterator, Serializable, Countable
    {
        protected $_data = array();
        protected $_original = array();
        protected static $_methods = array('array_change_key_case' => self::PRE, 'array_chunk' => self::PRE, 'array_combine' => self::PRE, 'array_count_datas' => self::PRE, 'array_diff_assoc' => self::PRE, 'array_diff_key' => self::PRE, 'array_diff_uassoc' => self::PRE, 'array_diff_ukey' => self::PRE, 'array_diff' => self::PRE, 'array_fill_keys' => self::PRE, 'array_filter' => self::PRE, 'array_flip' => self::PRE, 'array_intersect_assoc' => self::PRE, 'array_intersect_key' => self::PRE, 'array_intersect_uassoc' => self::PRE, 'array_intersect_ukey' => self::PRE, 'array_intersect' => self::PRE, 'array_keys' => self::PRE, 'array_merge_recursive' => self::PRE, 'array_merge' => self::PRE, 'array_pad' => self::PRE, 'array_reverse' => self::PRE, 'array_shift' => self::PRE, 'array_slice' => self::PRE, 'array_splice' => self::PRE, 'array_sum' => self::PRE, 'array_udiff_assoc' => self::PRE, 'array_udiff_uassoc' => self::PRE, 'array_udiff' => self::PRE, 'array_uintersect_assoc' => self::PRE, 'array_uintersect_uassoc' => self::PRE, 'array_uintersect' => self::PRE, 'array_unique' => self::PRE, 'array_datas' => self::PRE, 'count' => self::PRE, 'current' => self::PRE, 'each' => self::PRE, 'end' => self::PRE, 'extract' => self::PRE, 'key' => self::PRE, 'next' => self::PRE, 'prev' => self::PRE, 'sizeof' => self::PRE, 'array_fill' => self::POST, 'array_map' => self::POST, 'array_search' => self::POST, 'compact' => self::POST, 'implode' => self::POST, 'in_array' => self::POST, 'array_unshift' => self::REFERENCE, 'array_walk_recursive' => self::REFERENCE, 'array_walk' => self::REFERENCE, 'arsort' => self::REFERENCE, 'asort' => self::REFERENCE, 'krsort' => self::REFERENCE, 'ksort' => self::REFERENCE, 'natcasesort' => self::REFERENCE, 'natsort' => self::REFERENCE, 'reset' => self::REFERENCE, 'rsort' => self::REFERENCE, 'shuffle' => self::REFERENCE, 'sort' => self::REFERENCE, 'uasort' => self::REFERENCE, 'uksort' => self::REFERENCE, 'usort' => self::REFERENCE, 'array_push' => self::REFERENCE);

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __call($name, $args)
        {
            if (strpos($name, 'get') === 0) {
                $separator = '_';
                if (isset($args[0]) && is_scalar($args[0])) {
                    $separator = (string)$args[0];
                }
                $key = preg_replace("/([A-Z0-9])/", $separator . "$1", $name);
                $key = strtolower(substr($key, 3 + strlen($separator)));
                if (isset($this->_data[$key])) {
                    return $this->_data[$key];
                }
                return NULL;
            } else if (strpos($name, 'set') === 0) {
                $separator = '_';
                if (isset($args[1]) && is_scalar($args[1])) {
                    $separator = (string)$args[1];
                }
                $key = preg_replace("/([A-Z0-9])/", $separator . "$1", $name);
                $key = strtolower(substr($key, 3 + strlen($separator)));
                $this->__set($key, isset($args[0]) ? $args[0] : NULL);
                return $this;
            }
            try {
                return parent::__call($name, $args);
            } catch (Eden_Error $e) {
                Eden_Type_Error::i($e->getMessage())->trigger();
            }
        }

        public function __construct($data = array())
        {
            if (func_num_args() > 1 || !is_array($data)) {
                $data = func_get_args();
            }
            parent::__construct($data);
        }

        public function __set($name, $value)
        {
            $this->_data[$name] = $value;
        }

        public function __toString()
        {
            return json_encode($this->get());
        }

        public function copy($source, $destination)
        {
            $this->_data[$destination] = $this->_data[$source];
            return $this;
        }

        public function count()
        {
            return count($this->_data);
        }

        public function cut($key)
        {
            Eden_Type_Error::i()->argument(1, 'scalar');
            if (!isset($this->_data[$key])) {
                return $this;
            }
            unset($this->_data[$key]);
            $this->_data = array_values($this->_data);
            return $this;
        }

        public function current()
        {
            return current($this->_data);
        }

        public function each($callback)
        {
            Eden_Error::i()->argument(1, 'callable');
            foreach ($this->_data as $key => $value) {
                call_user_func($callback, $key, $value);
            }
            return $this;
        }

        public function isEmpty()
        {
            return empty($this->_data);
        }

        public function key()
        {
            return key($this->_data);
        }

        public function next()
        {
            next($this->_data);
        }

        public function offsetExists($offset)
        {
            return isset($this->_data[$offset]);
        }

        public function offsetGet($offset)
        {
            return isset($this->_data[$offset]) ? $this->_data[$offset] : NULL;
        }

        public function offsetSet($offset, $value)
        {
            if (is_null($offset)) {
                $this->_data[] = $value;
            } else {
                $this->_data[$offset] = $value;
            }
        }

        public function offsetUnset($offset)
        {
            unset($this->_data[$offset]);
        }

        public function paste($after, $value, $key = NULL)
        {
            Eden_Type_Error::i()->argument(1, 'scalar')->argument(3, 'scalar', 'null');
            $list = array();
            foreach ($this->_data as $i => $val) {
                $list[$i] = $val;
                if ($after != $i) {
                    continue;
                }
                if (!is_null($key)) {
                    $list[$key] = $value;
                    continue;
                }
                $list[] = $arrayValue;
            }
            if (is_null($key)) {
                $list = array_values($list);
            }
            $this->_data = $list;
            return $this;
        }

        public function rewind()
        {
            reset($this->_data);
        }

        public function serialize()
        {
            return json_encode($this->_data);
        }

        public function set($value)
        {
            Eden_Type_Error::i()->argument(1, 'array');
            $this->_data = $value;
            return $this;
        }

        public function unserialize($data)
        {
            $this->_data = json_decode($data, true);
            return $this;
        }

        public function valid()
        {
            return isset($this->_data[$this->key()]);
        }

        protected function _getMethodType(&$name)
        {
            if (isset(self::$_methods[$name])) {
                return self::$_methods[$name];
            }
            if (isset(self::$_methods['array_' . $name])) {
                $name = 'array_' . $name;
                return self::$_methods[$name];
            }
            $uncamel = strtolower(preg_replace("/([A-Z])/", "_$1", $name));
            if (isset(self::$_methods[$uncamel])) {
                $name = $uncamel;
                return self::$_methods[$name];
            }
            if (isset(self::$_methods['array_' . $uncamel])) {
                $name = 'array_' . $uncamel;
                return self::$_methods[$name];
            }
            return false;
        }
    }
}
/* Eden_Type_String */
if (!class_exists('Eden_Type_String')) {
    class Eden_Type_String extends Eden_Type_Abstract
    {
        protected static $_methods = array('addslashes' => self::PRE, 'bin2hex' => self::PRE, 'chunk_split' => self::PRE, 'convert_uudecode' => self::PRE, 'convert_uuencode' => self::PRE, 'crypt' => self::PRE, 'html_entity_decode' => self::PRE, 'htmlentities' => self::PRE, 'htmlspecialchars_decode' => self::PRE, 'htmlspecialchars' => self::PRE, 'lcfirst' => self::PRE, 'ltrim' => self::PRE, 'md5' => self::PRE, 'nl2br' => self::PRE, 'quoted_printable_decode' => self::PRE, 'quoted_printable_encode' => self::PRE, 'quotemeta' => self::PRE, 'rtrim' => self::PRE, 'sha1' => self::PRE, 'sprintf' => self::PRE, 'str_pad' => self::PRE, 'str_repeat' => self::PRE, 'str_rot13' => self::PRE, 'str_shuffle' => self::PRE, 'strip_tags' => self::PRE, 'stripcslashes' => self::PRE, 'stripslashes' => self::PRE, 'strpbrk' => self::PRE, 'stristr' => self::PRE, 'strrev' => self::PRE, 'strstr' => self::PRE, 'strtok' => self::PRE, 'strtolower' => self::PRE, 'strtoupper' => self::PRE, 'strtr' => self::PRE, 'substr_replace' => self::PRE, 'substr' => self::PRE, 'trim' => self::PRE, 'ucfirst' => self::PRE, 'ucwords' => self::PRE, 'vsprintf' => self::PRE, 'wordwrap' => self::PRE, 'count_chars' => self::PRE, 'hex2bin' => self::PRE, 'strlen' => self::PRE, 'strpos' => self::PRE, 'substr_compare' => self::PRE, 'substr_count' => self::PRE, 'str_ireplace' => self::POST, 'str_replace' => self::POST, 'preg_replace' => self::POST, 'explode' => self::POST);

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($data)
        {
            Eden_Type_Error::i()->argument(1, 'scalar');
            $data = (string)$data;
            parent::__construct($data);
        }

        public function __toString()
        {
            return $this->_data;
        }

        public function camelize($prefix = '-')
        {
            Eden_Type_Error::i()->argument(1, 'string');
            $this->_data = str_replace($prefix, ' ', $this->_data);
            $this->_data = str_replace(' ', '', ucwords($this->_data));
            $this->_data = strtolower(substr($name, 0, 1)) . substr($name, 1);
            return $this;
        }

        public function dasherize()
        {
            $this->_data = preg_replace("/[^a-zA-Z0-9_-\s]/i", '', $this->_data);
            $this->_data = str_replace(' ', '-', trim($this->_data));
            $this->_data = preg_replace("/-+/i", '-', $this->_data);
            $this->_data = strtolower($this->_data);
            return $this;
        }

        public function titlize($prefix = '-')
        {
            Eden_Type_Error::i()->argument(1, 'string');
            $this->_data = ucwords(str_replace($prefix, ' ', $this->_data));
            return $this;
        }

        public function uncamelize($prefix = '-')
        {
            Eden_Type_Error::i()->argument(1, 'string');
            $this->_data = strtolower(preg_replace("/([A-Z])/", $prefix . "$1", $this->_data));
            return $this;
        }

        public function summarize($words)
        {
            Eden_Type_Error::i()->argument(1, 'int');
            $this->_data = explode(' ', strip_tags($this->_data), $words);
            array_pop($this->_data);
            $this->_data = implode(' ', $this->_data);
            return $this;
        }

        protected function _getMethodType(&$name)
        {
            if (isset(self::$_methods[$name])) {
                return self::$_methods[$name];
            }
            if (isset(self::$_methods['str_' . $name])) {
                $name = 'str_' . $name;
                return self::$_methods[$name];
            }
            $uncamel = strtolower(preg_replace("/([A-Z])/", "_$1", $name));
            if (isset(self::$_methods[$uncamel])) {
                $name = $uncamel;
                return self::$_methods[$name];
            }
            if (isset(self::$_methods['str_' . $uncamel])) {
                $name = 'str_' . $uncamel;
                return self::$_methods[$name];
            }
            return false;
        }
    }
}
/* Eden_Collection */
if (!class_exists('Eden_Collection')) {
    class Eden_Collection extends Eden_Class implements ArrayAccess, Iterator, Serializable, Countable
    {
        const FIRST = 'first';
        const LAST = 'last';
        const MODEL = 'Eden_Model';
        protected $_list = array();
        protected $_model = self::MODEL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __call($name, $args)
        {
            if (strpos($name, 'get') === 0) {
                $value = isset($args[0]) ? $args[0] : NULL;
                $list = array();
                foreach ($this->_list as $i => $row) {
                    $list[] = $row->$name(isset($args[0]) ? $args[0] : NULL);
                }
                return $list;
            } else if (strpos($name, 'set') === 0) {
                $value = isset($args[0]) ? $args[0] : NULL;
                $separator = isset($args[1]) ? $args[1] : NULL;
                foreach ($this->_list as $i => $row) {
                    $row->$name($value, $separator);
                }
                return $this;
            }
            $found = false;
            foreach ($this->_list as $i => $row) {
                if (!method_exists($row, $name)) {
                    continue;
                }
                $found = true;
                $row->callThis($name, $args);
            }
            if ($found) {
                return $this;
            }
            try {
                return parent::__call($name, $args);
            } catch (Eden_Error $e) {
                Eden_Collection_Error::i($e->getMessage())->trigger();
            }
        }

        public function __construct(array $data = array())
        {
            $this->set($data);
        }

        public function __set($name, $value)
        {
            foreach ($this->_list as $i => $row) {
                $row[$name] = $value;
            }
            return $this;
        }

        public function __toString()
        {
            return json_encode($this->get());
        }

        public function add($row = array())
        {
            Eden_Collection_Error::i()->argument(1, 'array', $this->_model);
            if (is_array($row)) {
                $model = $this->_model;
                $row = $this->$model($row);
            }
            $this->_list[] = $row;
            return $this;
        }

        public function count()
        {
            return count($this->_list);
        }

        public function cut($index = self::LAST)
        {
            Eden_Collection_Error::i()->argument(1, 'string', 'int');
            if ($index == self::FIRST) {
                $index = 0;
            } else if ($index == self::LAST) {
                $index = count($this->_list) - 1;
            }
            if (isset($this->_list[$index])) {
                unset($this->_list[$index]);
            }
            $this->_list = array_values($this->_list);
            return $this;
        }

        public function each($callback)
        {
            Eden_Error::i()->argument(1, 'callable');
            foreach ($this->_list as $key => $value) {
                call_user_func($callback, $key, $value);
            }
            return $this;
        }

        public function current()
        {
            return current($this->_list);
        }

        public function get($modified = true)
        {
            Eden_Collection_Error::i()->argument(1, 'bool');
            $array = array();
            foreach ($this->_list as $i => $row) {
                $array[$i] = $row->get($modified);
            }
            return $array;
        }

        public function key()
        {
            return key($this->_list);
        }

        public function next()
        {
            next($this->_list);
        }

        public function offsetExists($offset)
        {
            return isset($this->_list[$offset]);
        }

        public function offsetGet($offset)
        {
            return isset($this->_list[$offset]) ? $this->_list[$offset] : NULL;
        }

        public function offsetSet($offset, $value)
        {
            Eden_Collection_Error::i()->argument(2, 'array', $this->_model);
            if (is_array($value)) {
                $model = $this->_model;
                $value = $this->$model($value);
            }
            if (is_null($offset)) {
                $this->_list[] = $value;
            } else {
                $this->_list[$offset] = $value;
            }
        }

        public function offsetUnset($offset)
        {
            $this->_list = Eden_Model::i($this->_list)->cut($offset)->get();
        }

        public function rewind()
        {
            reset($this->_list);
        }

        public function serialize()
        {
            return $this->__toString();
        }

        public function set(array $data = array())
        {
            foreach ($data as $row) {
                $this->add($row);
            }
            return $this;
        }

        public function setModel($model)
        {
            $error = Eden_Collection_Error::i()->argument(1, 'string');
            if (!is_subclass_of($model, 'Eden_Model')) {
                $error->setMessage(Eden_Collection_Error::NOT_SUB_MODEL)->addVariable($model)->trigger();
            }
            $this->_model = $model;
            return $this;
        }

        public function unserialize($data)
        {
            $this->_list = json_decode($data, true);
            return $this;
        }

        public function valid()
        {
            return isset($this->_list[key($this->_list)]);
        }
    }

    class Eden_Collection_Error extends Eden_Error
    {
        const NOT_COLLECTION = 'The data passed into __construct is not a collection.';
        const NOT_SUB_MODEL = 'Class %s is not a child of Eden_Model';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Curl */
if (!class_exists('Eden_Curl')) {
    class Eden_Curl extends Eden_Class implements ArrayAccess
    {
        const PUT = 'PUT';
        const DELETE = 'DELETE';
        const GET = 'GET';
        const POST = 'POST';
        protected $_options = array();
        protected $_meta = array();
        protected $_query = array();
        protected $_headers = array();
        protected static $_setBoolKeys = array('AutoReferer' => CURLOPT_AUTOREFERER, 'BinaryTransfer' => CURLOPT_BINARYTRANSFER, 'CookieSession' => CURLOPT_COOKIESESSION, 'CrlF' => CURLOPT_CRLF, 'DnsUseGlobalCache' => CURLOPT_DNS_USE_GLOBAL_CACHE, 'FailOnError' => CURLOPT_FAILONERROR, 'FileTime' => CURLOPT_FILETIME, 'FollowLocation' => CURLOPT_FOLLOWLOCATION, 'ForbidReuse' => CURLOPT_FORBID_REUSE, 'FreshConnect' => CURLOPT_FRESH_CONNECT, 'FtpUseEprt' => CURLOPT_FTP_USE_EPRT, 'FtpUseEpsv' => CURLOPT_FTP_USE_EPSV, 'FtpAppend' => CURLOPT_FTPAPPEND, 'FtpListOnly' => CURLOPT_FTPLISTONLY, 'Header' => CURLOPT_HEADER, 'HeaderOut' => CURLINFO_HEADER_OUT, 'HttpGet' => CURLOPT_HTTPGET, 'HttpProxyTunnel' => CURLOPT_HTTPPROXYTUNNEL, 'Netrc' => CURLOPT_NETRC, 'Nobody' => CURLOPT_NOBODY, 'NoProgress' => CURLOPT_NOPROGRESS, 'NoSignal' => CURLOPT_NOSIGNAL, 'Post' => CURLOPT_POST, 'Put' => CURLOPT_PUT, 'ReturnTransfer' => CURLOPT_RETURNTRANSFER, 'SslVerifyPeer' => CURLOPT_SSL_VERIFYPEER, 'TransferText' => CURLOPT_TRANSFERTEXT, 'UnrestrictedAuth' => CURLOPT_UNRESTRICTED_AUTH, 'Upload' => CURLOPT_UPLOAD, 'Verbose' => CURLOPT_VERBOSE);
        protected static $_setIntegerKeys = array('BufferSize' => CURLOPT_BUFFERSIZE, 'ClosePolicy' => CURLOPT_CLOSEPOLICY, 'ConnectTimeout' => CURLOPT_CONNECTTIMEOUT, 'ConnectTimeoutMs' => CURLOPT_CONNECTTIMEOUT_MS, 'DnsCacheTimeout' => CURLOPT_DNS_CACHE_TIMEOUT, 'FtpSslAuth' => CURLOPT_FTPSSLAUTH, 'HttpVersion' => CURLOPT_HTTP_VERSION, 'HttpAuth' => CURLOPT_HTTPAUTH, 'InFileSize' => CURLOPT_INFILESIZE, 'LowSpeedLimit' => CURLOPT_LOW_SPEED_LIMIT, 'LowSpeedTime' => CURLOPT_LOW_SPEED_TIME, 'MaxConnects' => CURLOPT_MAXCONNECTS, 'MaxRedirs' => CURLOPT_MAXREDIRS, 'Port' => CURLOPT_PORT, 'ProxyAuth' => CURLOPT_PROXYAUTH, 'ProxyPort' => CURLOPT_PROXYPORT, 'ProxyType' => CURLOPT_PROXYTYPE, 'ResumeFrom' => CURLOPT_RESUME_FROM, 'SslVerifyHost' => CURLOPT_SSL_VERIFYHOST, 'SslVersion' => CURLOPT_SSLVERSION, 'TimeCondition' => CURLOPT_TIMECONDITION, 'Timeout' => CURLOPT_TIMEOUT, 'TimeoutMs' => CURLOPT_TIMEOUT_MS, 'TimeValue' => CURLOPT_TIMEVALUE);
        protected static $_setStringKeys = array('CaInfo' => CURLOPT_CAINFO, 'CaPath' => CURLOPT_CAPATH, 'Cookie' => CURLOPT_COOKIE, 'CookieFile' => CURLOPT_COOKIEFILE, 'CookieJar' => CURLOPT_COOKIEJAR, 'CustomRequest' => CURLOPT_CUSTOMREQUEST, 'EgdSocket' => CURLOPT_EGDSOCKET, 'Encoding' => CURLOPT_ENCODING, 'FtpPort' => CURLOPT_FTPPORT, 'Interface' => CURLOPT_INTERFACE, 'Krb4Level' => CURLOPT_KRB4LEVEL, 'PostFields' => CURLOPT_POSTFIELDS, 'Proxy' => CURLOPT_PROXY, 'ProxyUserPwd' => CURLOPT_PROXYUSERPWD, 'RandomFile' => CURLOPT_RANDOM_FILE, 'Range' => CURLOPT_RANGE, 'Referer' => CURLOPT_REFERER, 'SslCipherList' => CURLOPT_SSL_CIPHER_LIST, 'SslCert' => CURLOPT_SSLCERT, 'SslCertPassword' => CURLOPT_SSLCERTPASSWD, 'SslCertType' => CURLOPT_SSLCERTTYPE, 'SslEngine' => CURLOPT_SSLENGINE, 'SslEngineDefault' => CURLOPT_SSLENGINE_DEFAULT, 'Sslkey' => CURLOPT_SSLKEY, 'SslKeyPasswd' => CURLOPT_SSLKEYPASSWD, 'SslKeyType' => CURLOPT_SSLKEYTYPE, 'Url' => CURLOPT_URL, 'UserAgent' => CURLOPT_USERAGENT, 'UserPwd' => CURLOPT_USERPWD);
        protected static $_setArrayKeys = array('Http200Aliases' => CURLOPT_HTTP200ALIASES, 'HttpHeader' => CURLOPT_HTTPHEADER, 'PostQuote' => CURLOPT_POSTQUOTE, 'Quote' => CURLOPT_QUOTE);
        protected static $_setFileKeys = array('File' => CURLOPT_FILE, 'InFile' => CURLOPT_INFILE, 'StdErr' => CURLOPT_STDERR, 'WriteHeader' => CURLOPT_WRITEHEADER);
        protected static $_setCallbackKeys = array('HeaderFunction' => CURLOPT_HEADERFUNCTION, 'ReadFunction' => CURLOPT_READFUNCTION, 'WriteFunction' => CURLOPT_WRITEFUNCTION);

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __call($name, $args)
        {
            if (strpos($name, 'set') === 0) {
                $method = substr($name, 3);
                if (isset(self::$_setBoolKeys[$method])) {
                    Eden_Curl_Error::i()->vargument($name, $args, 1, 'bool');
                    $key = self::$_setBoolKeys[$method];
                    $this->_options[$key] = $args[0];
                    return $this;
                }
                if (isset(self::$_setIntegerKeys[$method])) {
                    Eden_Curl_Error::i()->vargument($name, $args, 1, 'int');
                    $key = self::$_setIntegerKeys[$method];
                    $this->_options[$key] = $args[0];
                    return $this;
                }
                if (isset(self::$_setStringKeys[$method])) {
                    Eden_Curl_Error::i()->vargument($name, $args, 1, 'string');
                    $key = self::$_setStringKeys[$method];
                    $this->_options[$key] = $args[0];
                    return $this;
                }
                if (isset(self::$_setArrayKeys[$method])) {
                    Eden_Curl_Error::i()->vargument($name, $args, 1, 'array');
                    $key = self::$_setArrayKeys[$method];
                    $this->_options[$key] = $args[0];
                    return $this;
                }
                if (isset(self::$_setFileKeys[$method])) {
                    $key = self::$_setFileKeys[$method];
                    $this->_options[$key] = $args[0];
                    return $this;
                }
                if (isset(self::$_setCallbackKeys[$method])) {
                    Eden_Curl_Error::i()->vargument($name, $args, 1, 'array', 'string');
                    $key = self::$_setCallbackKeys[$method];
                    $this->_options[$key] = $args[0];
                    return $this;
                }
            }
            parent::__call($name, $args);
        }

        public function getDomDocumentResponse()
        {
            $this->_meta['response'] = $this->getResponse();
            $xml = new DOMDocument();
            $xml->loadXML($this->_meta['response']);
            return $xml;
        }

        public function getJsonResponse($assoc = true)
        {
            $this->_meta['response'] = $this->getResponse();
            Eden_Curl_Error::i()->argument(1, 'bool');
            return json_decode($this->_meta['response'], $assoc);
        }

        public function getMeta($key = NULL)
        {
            Eden_Curl_Error::i()->argument(1, 'string', 'null');
            if (isset($this->_meta[$key])) {
                return $this->_meta[$key];
            }
            return $this->_meta;
        }

        public function getQueryResponse()
        {
            $this->_meta['response'] = $this->getResponse();
            parse_str($this->_meta['response'], $response);
            return $response;
        }

        public function getResponse()
        {
            $curl = curl_init();
            $this->_addParameters()->_addHeaders();
            $this->_options[CURLOPT_RETURNTRANSFER] = true;
            curl_setopt_array($curl, $this->_options);
            $response = curl_exec($curl);
            $this->_meta = array('info' => curl_getinfo($curl, CURLINFO_HTTP_CODE), 'error_message' => curl_errno($curl), 'error_code' => curl_error($curl));
            curl_close($curl);
            unset($curl);
            return $response;
        }

        public function getSimpleXmlResponse()
        {
            $this->_meta['response'] = $this->getResponse();
            return simplexml_load_string($this->_meta['response']);
        }

        public function offsetExists($offset)
        {
            return isset($this->_option[$offset]);
        }

        public function offsetGet($offset)
        {
            return isset($this->_option[$offset]) ? $this->_option[$offset] : NULL;
        }

        public function offsetSet($offset, $value)
        {
            if (!is_null($offset)) {
                if (in_array($offset, $this->_setBoolKeys)) {
                    $method = array_search($offset, $this->_setBoolKeys);
                    $this->_call('set' . $method, array($value));
                }
                if (in_array($offset, $this->_setIntegerKeys)) {
                    $method = array_search($offset, $this->_setIntegerKeys);
                    $this->_call('set' . $method, array($value));
                }
                if (in_array($offset, $this->_setStringKeys)) {
                    $method = array_search($offset, $this->_setStringKeys);
                    $this->_call('set' . $method, array($value));
                }
                if (in_array($offset, $this->_setArrayKeys)) {
                    $method = array_search($offset, $this->_setArrayKeys);
                    $this->_call('set' . $method, array($value));
                }
                if (in_array($offset, $this->_setFileKeys)) {
                    $method = array_search($offset, $this->_setFileKeys);
                    $this->_call('set' . $method, array($value));
                }
                if (in_array($offset, $this->_setCallbackKeys)) {
                    $method = array_search($offset, $this->_setCallbackKeys);
                    $this->_call('set' . $method, array($value));
                }
            }
        }

        public function offsetUnset($offset)
        {
            unset($this->_option[$offset]);
        }

        public function send()
        {
            $curl = curl_init();
            $this->_addParameters()->_addHeaders();
            curl_setopt_array($curl, $this->_options);
            curl_exec($curl);
            $this->_meta = array('info' => curl_getinfo($curl, CURLINFO_HTTP_CODE), 'error_message' => curl_errno($curl), 'error_code' => curl_error($curl));
            curl_close($curl);
            unset($curl);
            return $this;
        }

        public function setCustomGet()
        {
            $this->setCustomRequest(self::GET);
            return $this;
        }

        public function setCustomPost()
        {
            $this->setCustomRequest(self::POST);
            return $this;
        }

        public function setCustomPut()
        {
            $this->setCustomRequest(self::PUT);
            return $this;
        }

        public function setCustomDelete()
        {
            $this->setCustomRequest(self::DELETE);
            return $this;
        }

        public function setPostFields($fields)
        {
            Eden_Curl_Error::i()->argument(1, 'array', 'string');
            $this->_options[CURLOPT_POSTFIELDS] = $fields;
            return $this;
        }

        public function setHeaders($key, $value = NULL)
        {
            Eden_Curl_Error::i()->argument(1, 'array', 'string')->argument(2, 'scalar', 'null');
            if (is_array($key)) {
                $this->_headers = $key;
                return $this;
            }
            $this->_headers[] = $key . ': ' . $value;
            return $this;
        }

        public function setUrlParameter($key, $value = NULL)
        {
            Eden_Curl_Error::i()->argument(1, 'array', 'string')->argument(2, 'scalar');
            if (is_array($key)) {
                $this->_param = $key;
                return $this;
            }
            $this->_param[$key] = $value;
        }

        public function verifyHost($on = true)
        {
            Eden_Curl_Error::i()->argument(1, 'bool');
            $this->_options[CURLOPT_SSL_VERIFYHOST] = $on ? 1 : 2;
            return $this;
        }

        public function verifyPeer($on = true)
        {
            Eden_Curl_Error::i()->argument(1, 'bool');
            $this->_options[CURLOPT_SSL_VERIFYPEER] = $on;
            return $this;
        }

        protected function _addHeaders()
        {
            if (empty($this->_headers)) {
                return $this;
            }
            $this->_options[CURLOPT_HTTPHEADER] = $this->_headers;
            return $this;
        }

        protected function _addParameters()
        {
            if (empty($this->_params)) {
                return $this;
            }
            $params = http_build_query($this->_params);
            if ($this->_options[CURLOPT_POST]) {
                $this->_options[CURLOPT_POSTFIELDS] = $params;
                return $this;
            }
            if (strpos($this->_options[CURLOPT_URL], '?') === false) {
                $params = '?' . $params;
            } else if (substr($this->_options[CURLOPT_URL], -1, 1) != '?') {
                $params = '&' . $params;
            }
            $this->_options[CURLOPT_URL] .= $params;
            return $this;
        }
    }

    class Eden_Curl_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Path */
if (!class_exists('Eden_Path')) {
    class Eden_Path extends Eden_Type_String implements ArrayAccess
    {
        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($path)
        {
            Eden_Path_Error::i()->argument(1, 'string');
            parent::__construct($this->_format($path));
        }

        public function __toString()
        {
            return $this->_data;
        }

        public function absolute($root = NULL)
        {
            Eden_Path_Error::i()->argument(1, 'string', 'null');
            if (is_dir($this->_data) || is_file($this->_data)) {
                return $this;
            }
            if (is_null($root)) {
                $root = $_SERVER['DOCUMENT_ROOT'];
            }
            $absolute = $this->_format($root) . $this->_data;
            if (is_dir($absolute) || is_file($absolute)) {
                $this->_data = $absolute;
                return $this;
            }
            Eden_Path_Error::i()->setMessage(Eden_Path_Error::FULL_PATH_NOT_FOUND)->addVariable($this->_data)->addVariable($absolute)->trigger();
        }

        public function append($path)
        {
            $error = Eden_Path_Error::i()->argument(1, 'string');
            $paths = func_get_args();
            foreach ($paths as $i => $path) {
                $error->argument($i + 1, $path, 'string');
                $this->_data .= $this->_format($path);
            }
            return $this;
        }

        public function getArray()
        {
            return explode('/', $this->_data);
        }

        public function offsetExists($offset)
        {
            return in_array($offset, $this->getArray());
        }

        public function offsetGet($offset)
        {
            $pathArray = $this->getArray();
            if ($offset == 'first') {
                $offset = 0;
            }
            if ($offset == 'last') {
                $offset = count($pathArray) - 1;
            }
            if (is_numeric($offset)) {
                return isset($pathArray[$offset]) ? $pathArray[$offset] : NULL;
            }
            return NULL;
        }

        public function offsetSet($offset, $value)
        {
            if (is_null($offset)) {
                $this->append($value);
            } else if ($offset == 'prepend') {
                $this->prepend($value);
            } else if ($offset == 'replace') {
                $this->replace($value);
            } else {
                $pathArray = $this->getArray();
                if ($offset > 0 && $offset < count($pathArray)) {
                    $pathArray[$offset] = $value;
                    $this->_data = implode('/', $pathArray);
                }
            }
        }

        public function offsetUnset($offset)
        {
        }

        public function prepend($path)
        {
            $error = Eden_Path_Error::i()->argument(1, 'string');
            $paths = func_get_args();
            foreach ($paths as $i => $path) {
                $error->argument($i + 1, $path, 'string');
                $this->_data = $this->_format($path) . $this->_data;
            }
            return $this;
        }

        public function pop()
        {
            $pathArray = $this->getArray();
            $path = array_pop($pathArray);
            $this->_data = implode('/', $pathArray);
            return $path;
        }

        public function replace($path)
        {
            Eden_Path_Error::i()->argument(1, 'string');
            $pathArray = $this->getArray();
            array_pop($pathArray);
            $pathArray[] = $path;
            $this->_data = implode('/', $pathArray);
            return $this;
        }

        protected function _format($path)
        {
            $path = str_replace('\\', '/', $path);
            $path = str_replace('//', '/', $path);
            if (substr($path, -1, 1) == '/') {
                $path = substr($path, 0, -1);
            }
            if (substr($path, 0, 1) != '/' && !preg_match("/^[A-Za-z]+\:/", $path)) {
                $path = '/' . $path;
            }
            return $path;
        }
    }

    class Eden_Path_Error extends Eden_Error
    {
        const FULL_PATH_NOT_FOUND = 'The path %s or %s was not found.';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_File */
if (!class_exists('Eden_File')) {
    class Eden_File extends Eden_Path
    {
        protected $_path = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function isFile()
        {
            return file_exists($this->_data);
        }

        public function getBase()
        {
            $pathInfo = pathinfo($this->_data);
            return $pathInfo['filename'];
        }

        public function getContent()
        {
            $this->absolute();
            if (!is_file($this->_data)) {
                Eden_File_Error::i()->setMessage(Eden_File_Error::PATH_IS_NOT_FILE)->addVariable($this->_data)->trigger();
            }
            return file_get_contents($this->_data);
        }

        public function getData()
        {
            $this->absolute();
            return include($this->_data);
        }

        public function getExtension()
        {
            $pathInfo = pathinfo($this->_data);
            if (!isset($pathInfo['extension'])) {
                return NULL;
            }
            return $pathInfo['extension'];
        }

        public function getFolder()
        {
            return dirname($this->_data);
        }

        public function getMime()
        {
            $this->absolute();
            if (function_exists('mime_content_type')) {
                return mime_content_type($this->_data);
            }
            if (function_exists('finfo_open')) {
                $resource = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($resource, $this->_data);
                finfo_close($finfo);
                return $mime;
            }
            $extension = strtolower($this->getExtension());
            $types = self::$_mimeTypes;
            if (isset($types[$extension])) {
                return $types[$extension];
            }
            return $types['class'];
        }

        public function getName()
        {
            return basename($this->_data);
        }

        public function getSize()
        {
            $this->absolute();
            return filesize($this->_data);
        }

        public function getTime()
        {
            $this->absolute();
            return filemtime($this->_data);
        }

        public function setContent($content)
        {
            Eden_File_Error::i()->argument(1, 'string');
            try {
                $this->absolute();
            } catch (Eden_Path_Error $e) {
                $this->touch();
            }
            file_put_contents($this->_data, $content);
            return $this;
        }

        public function setData($variable)
        {
            return $this->setContent(" //-->\nreturn " . var_export($variable, true) . ";");
        }

        public function remove()
        {
            $this->absolute();
            if (is_file($this->_data)) {
                unlink($this->_data);
                return $this;
            }
            return $this;
        }

        public function touch()
        {
            touch($this->_data);
            return $this;
        }

        protected static $_mimeTypes = array('ai' => 'application/postscript', 'aif' => 'audio/x-aiff', 'aifc' => 'audio/x-aiff', 'aiff' => 'audio/x-aiff', 'asc' => 'text/plain', 'atom' => 'application/atom+xml', 'au' => 'audio/basic', 'avi' => 'video/x-msvideo', 'bcpio' => 'application/x-bcpio', 'bin' => 'application/octet-stream', 'bmp' => 'image/bmp', 'cdf' => 'application/x-netcdf', 'cgm' => 'image/cgm', 'class' => 'application/octet-stream', 'cpio' => 'application/x-cpio', 'cpt' => 'application/mac-compactpro', 'csh' => 'application/x-csh', 'css' => 'text/css', 'dcr' => 'application/x-director', 'dif' => 'video/x-dv', 'dir' => 'application/x-director', 'djv' => 'image/vnd.djvu', 'djvu' => 'image/vnd.djvu', 'dll' => 'application/octet-stream', 'dmg' => 'application/octet-stream', 'dms' => 'application/octet-stream', 'doc' => 'application/msword', 'dtd' => 'application/xml-dtd', 'dv' => 'video/x-dv', 'dvi' => 'application/x-dvi', 'dxr' => 'application/x-director', 'eps' => 'application/postscript', 'etx' => 'text/x-setext', 'exe' => 'application/octet-stream', 'ez' => 'application/andrew-inset', 'gif' => 'image/gif', 'gram' => 'application/srgs', 'grxml' => 'application/srgs+xml', 'gtar' => 'application/x-gtar', 'hdf' => 'application/x-hdf', 'hqx' => 'application/mac-binhex40', 'htm' => 'text/html', 'html' => 'text/html', 'ice' => 'x-conference/x-cooltalk', 'ico' => 'image/x-icon', 'ics' => 'text/calendar', 'ief' => 'image/ief', 'ifb' => 'text/calendar', 'iges' => 'model/iges', 'igs' => 'model/iges', 'jnlp' => 'application/x-java-jnlp-file', 'jp2' => 'image/jp2', 'jpe' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'js' => 'application/x-javascript', 'kar' => 'audio/midi', 'latex' => 'application/x-latex', 'lha' => 'application/octet-stream', 'lzh' => 'application/octet-stream', 'm3u' => 'audio/x-mpegurl', 'm4a' => 'audio/mp4a-latm', 'm4b' => 'audio/mp4a-latm', 'm4p' => 'audio/mp4a-latm', 'm4u' => 'video/vnd.mpegurl', 'm4v' => 'video/x-m4v', 'mac' => 'image/x-macpaint', 'man' => 'application/x-troff-man', 'mathml' => 'application/mathml+xml', 'me' => 'application/x-troff-me', 'mesh' => 'model/mesh', 'mid' => 'audio/midi', 'midi' => 'audio/midi', 'mif' => 'application/vnd.mif', 'mov' => 'video/quicktime', 'movie' => 'video/x-sgi-movie', 'mp2' => 'audio/mpeg', 'mp3' => 'audio/mpeg', 'mp4' => 'video/mp4', 'mpe' => 'video/mpeg', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg', 'mpga' => 'audio/mpeg', 'ms' => 'application/x-troff-ms', 'msh' => 'model/mesh', 'mxu' => 'video/vnd.mpegurl', 'nc' => 'application/x-netcdf', 'oda' => 'application/oda', 'ogg' => 'application/ogg', 'pbm' => 'image/x-portable-bitmap', 'pct' => 'image/pict', 'pdb' => 'chemical/x-pdb', 'pdf' => 'application/pdf', 'pgm' => 'image/x-portable-graymap', 'pgn' => 'application/x-chess-pgn', 'pic' => 'image/pict', 'pict' => 'image/pict', 'png' => 'image/png', 'pnm' => 'image/x-portable-anymap', 'pnt' => 'image/x-macpaint', 'pntg' => 'image/x-macpaint', 'ppm' => 'image/x-portable-pixmap', 'ppt' => 'application/vnd.ms-powerpoint', 'ps' => 'application/postscript', 'qt' => 'video/quicktime', 'qti' => 'image/x-quicktime', 'qtif' => 'image/x-quicktime', 'ra' => 'audio/x-pn-realaudio', 'ram' => 'audio/x-pn-realaudio', 'ras' => 'image/x-cmu-raster', 'rdf' => 'application/rdf+xml', 'rgb' => 'image/x-rgb', 'rm' => 'application/vnd.rn-realmedia', 'roff' => 'application/x-troff', 'rtf' => 'text/rtf', 'rtx' => 'text/richtext', 'sgm' => 'text/sgml', 'sgml' => 'text/sgml', 'sh' => 'application/x-sh', 'shar' => 'application/x-shar', 'silo' => 'model/mesh', 'sit' => 'application/x-stuffit', 'skd' => 'application/x-koan', 'skm' => 'application/x-koan', 'skp' => 'application/x-koan', 'skt' => 'application/x-koan', 'smi' => 'application/smil', 'smil' => 'application/smil', 'snd' => 'audio/basic', 'so' => 'application/octet-stream', 'spl' => 'application/x-futuresplash', 'src' => 'application/x-wais-source', 'sv4cpio' => 'application/x-sv4cpio', 'sv4crc' => 'application/x-sv4crc', 'svg' => 'image/svg+xml', 'swf' => 'application/x-shockwave-flash', 't' => 'application/x-troff', 'tar' => 'application/x-tar', 'tcl' => 'application/x-tcl', 'tex' => 'application/x-tex', 'texi' => 'application/x-texinfo', 'texinfo' => 'application/x-texinfo', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'tr' => 'application/x-troff', 'tsv' => 'text/tab-separated-values', 'txt' => 'text/plain', 'ustar' => 'application/x-ustar', 'vcd' => 'application/x-cdlink', 'vrml' => 'model/vrml', 'vxml' => 'application/voicexml+xml', 'wav' => 'audio/x-wav', 'wbmp' => 'image/vnd.wap.wbmp', 'wbmxl' => 'application/vnd.wap.wbxml', 'wml' => 'text/vnd.wap.wml', 'wmlc' => 'application/vnd.wap.wmlc', 'wmls' => 'text/vnd.wap.wmlscript', 'wmlsc' => 'application/vnd.wap.wmlscriptc', 'wrl' => 'model/vrml', 'xbm' => 'image/x-xbitmap', 'xht' => 'application/xhtml+xml', 'xhtml' => 'application/xhtml+xml', 'xls' => 'application/vnd.ms-excel', 'xml' => 'application/xml', 'xpm' => 'image/x-xpixmap', 'xsl' => 'application/xml', 'xslt' => 'application/xslt+xml', 'xul' => 'application/vnd.mozilla.xul+xml', 'xwd' => 'image/x-xwindowdump', 'xyz' => 'chemical/x-xyz', 'zip' => 'application/zip');
    }

    class Eden_File_Error extends Eden_Path_Error
    {
        const PATH_IS_NOT_FILE = 'Path %s is not a file in the system.';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Folder */
if (!class_exists('Eden_Folder')) {
    class Eden_Folder extends Eden_Path
    {
        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function create($chmod = 0755)
        {
            if (!is_int($chmod) || $chmod < 0 || $chmod > 777) {
                Eden_Folder_Error::i(Eden_Folder_Exception::CHMOD_IS_INVALID)->trigger();
            }
            if (!is_dir($this->_data)) {
                mkdir($this->_data, $chmod, true);
            }
            return $this;
        }

        public function getFiles($regex = NULL, $recursive = false)
        {
            $error = Eden_Folder_Error::i()->argument(1, 'string', 'null')->argument(2, 'bool');
            $this->absolute();
            $files = array();
            if ($handle = opendir($this->_data)) {
                while (false !== ($file = readdir($handle))) {
                    if (filetype($this->_data . '/' . $file) == 'file' && (!$regex || preg_match($regex, $file))) {
                        $files[] = Eden_File::i($this->_data . '/' . $file);
                    } else if ($recursive && $file != '.' && $file != '..' && filetype($this->_data . '/' . $file) == 'dir') {
                        $subfiles = self::i($this->_data . '/' . $file);
                        $files = array_merge($files, $subfiles->getFiles($regex, $recursive));
                    }
                }
                closedir($handle);
            }
            return $files;
        }

        public function getFolders($regex = NULL, $recursive = false)
        {
            Eden_Folder_Error::i()->argument(1, 'string', 'null')->argument(2, 'bool');
            $this->absolute();
            $folders = array();
            if ($handle = opendir($this->_data)) {
                while (false !== ($folder = readdir($handle))) {
                    if ($folder != '.' && $folder != '..' && filetype($this->_data . '/' . $folder) == 'dir' && (!$regex || preg_match($regex, $folder))) {
                        $folders[] = Eden_Folder::i($this->_data . '/' . $folder);
                        if ($recursive) {
                            $subfolders = Eden_Folder::i($this->_data . '/' . $folder);
                            $folders = array_merge($folders, $subfolders->getFolders($regex, $recursive));
                        }
                    }
                }
                closedir($handle);
            }
            return $folders;
        }

        public function getName()
        {
            $pathArray = $this->getArray();
            return array_pop($pathArray);
        }

        public function isFile()
        {
            return file_exists($this->_data);
        }

        public function isFolder($path = NULL)
        {
            Eden_Folder_Error::i()->argument(1, 'string', 'null');
            if (is_string($path)) {
                return is_dir($this->_data . '/' . $path);
            }
            return is_dir($this->_data);
        }

        public function remove()
        {
            $path = $this->absolute();
            if (is_dir($path)) {
                rmdir($path);
            }
            return $this;
        }

        public function removeFiles($regex = NULL)
        {
            Eden_Folder_Error::i()->argument(1, 'string', 'null');
            $files = $this->getFiles($regex);
            if (empty($files)) {
                return $this;
            }
            foreach ($files as $file) {
                $file->remove();
            }
            return $this;
        }

        public function removeFolders($regex = NULL)
        {
            Eden_Folder_Error::i()->argument(1, 'string', 'null');
            $this->absolute();
            $folders = $this->getFolders($regex);
            if (empty($folders)) {
                return $this;
            }
            foreach ($folders as $folder) {
                $folder->remove();
            }
            return $this;
        }

        public function truncate()
        {
            $this->removeFolders();
            $this->removeFiles();
            return $this;
        }
    }

    class Eden_Folder_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Block */
if (!class_exists('Eden_Block')) {
    abstract class Eden_Block extends Eden_Class
    {
        protected static $_blockRoot = NULL;
        private static $_global = array();

        public function __toString()
        {
            try {
                return (string)$this->render();
            } catch (Exception $e) {
                Eden_Error_Event::i()->exceptionHandler($e);
            }
            return '';
        }

        abstract public function getTemplate();

        abstract public function getVariables();

        public function render()
        {
            return Eden_Template::i()->set($this->getVariables())->parsePhp($this->getTemplate());
        }

        public function setBlockRoot($root)
        {
            Eden_Error::i()->argument(1, 'folder');
            self::$_blockRoot = $root;
            return $this;
        }

        protected function _getGlobal($value)
        {
            if (in_array($value, self::$_global)) {
                return false;
            }
            self::$_global[] = $value;
            return $value;
        }
    }
}
/* Eden_Model */
if (!class_exists('Eden_Model')) {
    class Eden_Model extends Eden_Type_Array
    {
        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        protected function _getMethodType(&$name)
        {
            return false;
        }
    }

    class Eden_Model_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden */
if (!class_exists('Eden')) {
    function eden()
    {
        $class = Eden::i();
        if (func_num_args() == 0) {
            return $class;
        }
        $args = func_get_args();
        return $class->__invoke($args);
    }

    class Eden extends Eden_Event
    {
        protected $_root = NULL;
        protected static $_active = NULL;

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function __construct()
        {
            if (!self::$_active) {
                self::$_active = $this;
            }
            $this->_root = dirname(__FILE__);
        }

        public function __call($name, $args)
        {
            try {
                return parent::__call($name, $args);
            } catch (Eden_Route_Exception $e) {
                return parent::__call('Eden_' . $name, $args);
            }
        }

        public function setRoot($root)
        {
            Eden_Error::i()->argument(1, 'string');
            if (!class_exists('Eden_Path')) {
                Eden_Loader::i()->load('Eden_Path');
            }
            $this->_root = (string)Eden_Path::i($root);
            return $this;
        }

        public function getRoot()
        {
            return $this->_root;
        }

        public function getActiveApp()
        {
            return self::$_active;
        }

        public function setLoader()
        {
            if (!class_exists('Eden_Loader')) {
                require_once dirname(__FILE__) . '/eden/loader.php';
            }
            spl_autoload_register(array(Eden_Loader::i(), 'handler'));
            if (!class_exists('Eden_Path')) {
                Eden_Loader::i()->addRoot(dirname(__FILE__))->load('Eden_Path');
            }
            $paths = func_get_args();
            if (empty($paths)) {
                return $this;
            }
            $paths = array_unique($paths);
            foreach ($paths as $i => $path) {
                if (!is_string($path) && !is_null($path)) {
                    continue;
                }
                if ($path) {
                    $path = (string)Eden_Path::i($path);
                } else {
                    $path = $this->_root;
                }
                if (!is_dir($path)) {
                    $path = $this->_root . $path;
                }
                if (is_dir($path)) {
                    Eden_Loader::i()->addRoot($path);
                }
            }
            return $this;
        }

        public function routeClasses($routes)
        {
            Eden_Error::i()->argument(1, 'string', 'array', 'bool');
            $route = Eden_Route::i()->getClass();
            if ($routes === true) {
                $route->route('Cache', 'Eden_Cache')->route('Registry', 'Eden_Registry')->route('Model', 'Eden_Model')->route('Collection', 'Eden_Collection')->route('Cookie', 'Eden_Cookie')->route('Session', 'Eden_Session')->route('Template', 'Eden_Template')->route('Curl', 'Eden_Curl')->route('Event', 'Eden_Event')->route('Path', 'Eden_Path')->route('File', 'Eden_File')->route('Folder', 'Eden_Folder')->route('Image', 'Eden_Image')->route('Mysql', 'Eden_Mysql')->route('Type', 'Eden_Type');
                return $this;
            }
            if (is_string($routes)) {
                $routes = include($routes);
            }
            foreach ($routes as $alias => $class) {
                $route->route($alias, $class);
            }
            return $this;
        }

        public function routeMethods($routes)
        {
            Eden_Error::i()->argument(1, 'string', 'array', 'bool');
            $route = Eden_Route::i()->getMethod();
            if (is_bool($routes)) {
                $route->route(NULL, 'output', 'Eden_Debug');
                return $this;
            }
            if (is_string($routes)) {
                $routes = include($routes);
            }
            foreach ($routes as $method => $routePath) {
                if (is_string($routePath)) {
                    $routePath = array($routePath);
                }
                if (is_array($routePath) && !empty($routePath)) {
                    if (count($routePath) == 1) {
                        $routePath[] = $method;
                    }
                    $route->route($method, $routePath[0], $routePath[1]);
                }
            }
            return $this;
        }

        public function startSession()
        {
            Eden_Session::i()->start();
            return $this;
        }

        public function setTimezone($zone)
        {
            Eden_Error::i()->argument(1, 'string');
            date_default_timezone_set($zone);
            return $this;
        }
    }
}
/* Eden_Template */
if (!class_exists('Eden_Template')) {
    class Eden_Template extends Eden_Class
    {
        const ENGINE_PATTERN = '!{([@$])([A-Za-z0-9:_]+)}|{([A-Za-z:_][A-Za-z0-9:_]*)(\s*,(.+?))?(/}|}(.*?){/\\3})!s';
        protected $_data = array();
        protected static $_stack = array();
        private $_callback = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function set($data, $value = NULL)
        {
            Eden_Template_Error::i()->argument(1, 'array', 'string');
            if (is_array($data)) {
                $this->_data = $data;
                return $this;
            }
            $this->_data[$data] = $value;
            return $this;
        }

        public function parseString($string)
        {
            Eden_Template_Error::i()->argument(1, 'string');
            foreach ($this->_data as $key => $value) {
                $string = str_replace($key, $value, $string);
            }
            return $string;
        }

        public function parsePhp($____file, $___evalString = false)
        {
            Eden_Template_Error::i()->argument(1, $____file, 'string')->argument(2, $___evalString, 'bool');
            extract($this->_data, EXTR_SKIP);
            if ($___evalString) {
                return eval('?>' . $___file . ';');
            }
            ob_start();
            include $____file;
            $____contents = ob_get_contents();
            ob_end_clean();
            return $____contents;
        }

        public function parseEngine($template, $callback = NULL)
        {
            $this->_callback = $callback;
            return preg_replace_callback(self::ENGINE_PATTERN, array($this, '_engineParseResults'), $template);
        }

        protected function _engineParseResults($matches)
        {
            switch (count($matches)) {
                case 3:
                    if (!isset($this->_data[$matches[2]])) {
                        if ($this->_callback) {
                            return call_user_func($this->_callback, $matches[2], $matches[1]);
                        }
                        return NULL;
                    }
                    return $this->_data[$matches[2]];
                case 7:
                    $args = str_replace(array(' ', ',', ' '), array(' ', '', '&'), trim($matches[5]));
                    parse_str($args, $args);
                    if (!isset($this->_data[$matches[3]])) {
                        if ($this->_callback) {
                            return call_user_func($this->_callback, $matches[3], '$', $args);
                        }
                        return NULL;
                    }
                    return $this->_data[$matches[3]];
                case 8:
                    $args = str_replace(array(' ', ',', ' '), array(' ', '', '&'), trim($matches[5]));
                    parse_str($args, $args);
                    if (!isset($this->_data[$matches[3]])) {
                        if ($this->_callback) {
                            return call_user_func($this->_callback, $matches[3], $matches[7], $args);
                        }
                        return NULL;
                    }
                    $rows = array();
                    foreach ($this->_data[$matches[3]] as $j => $row) {
                        if (!is_array($row)) {
                            $rows[] = self::i()->set($this->_data[$matches[3]])->parseEngine($matches[7]);
                            break;
                        }
                        $rows[] = self::i()->set($row)->parseEngine($matches[7]);
                    }
                    return implode("\n", $rows);
                default:
                    return NULL;
            }
        }
    }

    class Eden_Template_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Session */
if (!class_exists('Eden_Session')) {
    class Eden_Session extends Eden_Class implements ArrayAccess, Iterator
    {
        protected static $_session = false;

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function __toString()
        {
            if (!self::$_session) {
                return '[]';
            }
            return json_encode($_SESSION);
        }

        public function clear()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            $_SESSION = array();
            return $this;
        }

        public function current()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            return current($_SESSION);
        }

        public function get($key = NULL)
        {
            $error = Eden_Session_Error::i()->argument(1, 'string', 'null');
            if (!self::$_session) {
                $error->setMessage(Eden_Session_Error::ERROR_ERROR_NOT_STARTED)->trigger();
            }
            if (is_null($key)) {
                return $_SESSION;
            }
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
            return NULL;
        }

        public function getId()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            return session_id();
        }

        public function key()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            return key($_SESSION);
        }

        public function next()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            next($_SESSION);
        }

        public function offsetExists($offset)
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            return isset($_SESSION[$offset]);
        }

        public function offsetGet($offset)
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            return isset($_SESSION[$offset]) ? $_SESSION[$offset] : NULL;
        }

        public function offsetSet($offset, $value)
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            if (is_null($offset)) {
                $_SESSION[] = $value;
            } else {
                $_SESSION[$offset] = $value;
            }
        }

        public function offsetUnset($offset)
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            unset($_SESSION[$offset]);
        }

        public function remove($name)
        {
            Eden_Session_Error::i()->argument(1, 'string');
            if (isset($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            return $this;
        }

        public function rewind()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            reset($_SESSION);
        }

        public function set($data, $value = NULL)
        {
            $error = Eden_Session_Error::i()->argument(1, 'array', 'string');
            if (!self::$_session) {
                $error->setMessage(Eden_Session_Error::ERROR_ERROR_NOT_STARTED)->trigger();
            }
            if (is_array($data)) {
                $_SESSION = $data;
                return $this;
            }
            $_SESSION[$data] = $value;
            return $this;
        }

        public function setId($sid)
        {
            $error = Eden_Session_Error::i()->argument(1, 'numeric');
            if (!self::$_session) {
                $error->setMessage(Eden_Session_Error::ERROR_ERROR_NOT_STARTED)->trigger();
            }
            return session_id((int)$sid);
        }

        public function start()
        {
            if (!session_id()) {
                self::$_session = session_start();
            }
            return $this;
        }

        public function stop()
        {
            self::$_session = false;
            session_write_close();
            return $this;
        }

        public function valid()
        {
            if (!self::$_session) {
                Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
            }
            return isset($_SESSION[$this->key()]);
        }
    }

    class Eden_Session_Error extends Eden_Error
    {
        const ERROR_NOT_STARTED = 'Session is not started.Try using Eden_Session->start() first.';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Cookie */
if (!class_exists('Eden_Cookie')) {
    class Eden_Cookie extends Eden_Class implements ArrayAccess, Iterator
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function clear()
        {
            foreach ($_COOKIE as $key => $value) {
                $this->remove($key);
            }
            return $this;
        }

        public function current()
        {
            return current($_COOKIE);
        }

        public function get($key = NULL)
        {
            Eden_Cookie_Error::i()->argument(1, 'string', 'null');
            if (is_null($key)) {
                return $_COOKIE;
            }
            if (isset($_COOKIE[$key])) {
                return $_COOKIE[$key];
            }
            return NULL;
        }

        public function key()
        {
            return key($_COOKIE);
        }

        public function next()
        {
            next($_COOKIE);
        }

        public function offsetExists($offset)
        {
            return isset($_COOKIE[$offset]);
        }

        public function offsetGet($offset)
        {
            return isset($_COOKIE[$offset]) ? $_COOKIE[$offset] : NULL;
        }

        public function offsetSet($offset, $value)
        {
            $this->set($offset, $value, strtotime('+10 years'));
        }

        public function offsetUnset($offset)
        {
            $this->remove($offset);
        }

        public function remove($name)
        {
            Eden_Cookie_Error::i()->argument(1, 'string');
            $this->set($name, NULL, time() - 3600);
            if (isset($_COOKIE[$name])) {
                unset($_COOKIE[$name]);
            }
            return $this;
        }

        public function rewind()
        {
            reset($_COOKIE);
        }

        public function set($key, $data = NULL, $expires = 0, $path = NULL, $domain = NULL, $secure = false, $httponly = false)
        {
            Eden_Cookie_Error::i()->argument(1, 'string')->argument(2, 'string', 'numeric', 'null')->argument(3, 'int')->argument(4, 'string', 'null')->argument(5, 'string', 'null')->argument(6, 'bool')->argument(7, 'bool');
            $_COOKIE[$key] = $data;
            setcookie($key, $data, $expires, $path, $domain, $secure, $httponly);
            return $this;
        }

        public function setData(array $data, $expires = 0, $path = NULL, $domain = NULL, $secure = false, $httponly = false)
        {
            foreach ($data as $key => $value) {
                $this->set($key, $value, $expires, $path, $domain, $secure, $httponly);
            }
            return $this;
        }

        public function setSecure($key, $data = NULL, $expires = 0, $path = NULL, $domain = NULL)
        {
            return $this->set($key, $data, $expires, $path, $domain, true, false);
        }

        public function setSecureData(array $data, $expires = 0, $path = NULL, $domain = NULL)
        {
            $this->set($data, $expires, $path, $domain, true, false);
            return $this;
        }

        public function valid()
        {
            return isset($_COOKIE[$this->key()]);
        }
    }

    class Eden_Cookie_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Registry */
if (!class_exists('Eden_Registry')) {
    class Eden_Registry extends Eden_Type_Array
    {
        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($data = array())
        {
            if (func_num_args() > 1 || !is_array($data)) {
                $data = func_get_args();
            }
            foreach ($data as $key => $value) {
                if (!is_array($value)) {
                    continue;
                }
                $class = get_class($this);
                $data[$key] = $this->$class($value);
            }
            parent::__construct($data);
        }

        public function __toString()
        {
            return json_encode($this->getArray());
        }

        public function get($modified = true)
        {
            $args = func_get_args();
            if (count($args) == 0) {
                return $this;
            }
            $key = array_shift($args);
            if ($key === false) {
                if (count($args) == 0) {
                    return $this->getArray();
                }
                $modified = $key;
                $key = array_shift($args);
                array_unshift($args, $modified);
            }
            if (!isset($this->_data[$key])) {
                return NULL;
            }
            if (count($args) == 0) {
                return $this->_data[$key];
            }
            if ($this->_data[$key] instanceof Eden_Registry) {
                return call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
            }
            return NULL;
        }

        public function getArray($modified = true)
        {
            $array = array();
            foreach ($this->_data as $key => $data) {
                if ($data instanceof Eden_Registry) {
                    $array[$key] = $data->getArray($modified);
                    continue;
                }
                $array[$key] = $data;
            }
            return $array;
        }

        public function isKey()
        {
            $args = func_get_args();
            if (count($args) == 0) {
                return $this;
            }
            $key = array_shift($args);
            if (!isset($this->_data[$key])) {
                return false;
            }
            if (count($args) == 0) {
                return true;
            }
            if ($this->_data[$key] instanceof Eden_Registry) {
                return call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
            }
            return false;
        }

        public function offsetGet($offset)
        {
            if (!isset($this->_data[$offset])) {
                return NULL;
            }
            if ($this->_data[$offset] instanceof Eden_Registry) {
                return $this->_data[$offset]->getArray();
            }
            return $this->_data[$offset];
        }

        public function remove()
        {
            $args = func_get_args();
            if (count($args) == 0) {
                return $this;
            }
            $key = array_shift($args);
            if (!isset($this->_data[$key])) {
                return $this;
            }
            if (count($args) == 0) {
                unset($this->_data[$key]);
                return $this;
            }
            if ($this->_data[$key] instanceof Eden_Registry) {
                return call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
            }
            return $this;
        }

        public function set($value)
        {
            $args = func_get_args();
            if (count($args) < 2) {
                return $this;
            }
            $key = array_shift($args);
            if (count($args) == 1) {
                if (is_array($args[0])) {
                    $args[0] = self::i($args[0]);
                }
                $this->_data[$key] = $args[0];
                return $this;
            }
            if (!isset($this->_data[$key]) || !($this->_data[$key] instanceof Eden_Registry)) {
                $this->_data[$key] = self::i();
            }
            call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
            return $this;
        }
    }
}
/* Eden_Image */
if (!class_exists('Eden_Image')) {
    class Eden_Image extends Eden_Class
    {
        protected $_resource = NULL;
        protected $_width = 0;
        protected $_height = 0;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($data, $type = NULL, $path = true, $quality = 75)
        {
            Eden_Image_Error::i()->argument(1, 'string')->argument(2, 'string', 'null')->argument(3, 'bool')->argument(4, 'int');
            $this->_type = $type;
            $this->_quality = $quality;
            $this->_resource = $this->_getResource($data, $path);
            list($this->_width, $this->_height) = $this->getDimensions();
        }

        public function __destruct()
        {
            if ($this->_resource) {
                imagedestroy($this->_resource);
            }
        }

        public function __toString()
        {
            ob_start();
            switch ($this->_type) {
                case 'gif':
                    imagegif($this->_resource);
                    break;
                case 'png':
                    $quality = (100 - $this->_quality) / 10;
                    if ($quality > 9) {
                        $quality = 9;
                    }
                    imagepng($this->_resource, NULL, $quality);
                    break;
                case 'bmp':
                case 'wbmp':
                    imagewbmp($this->_resource, NULL, $this->_quality);
                    break;
                case 'jpg':
                case 'jpeg':
                case 'pjpeg':
                default:
                    imagejpeg($this->_resource, NULL, $this->_quality);
                    break;
            }
            return ob_get_clean();
        }

        public function blur()
        {
            imagefilter($this->_resource, IMG_FILTER_SELECTIVE_BLUR);
            return $this;
        }

        public function brightness($level)
        {
            Eden_Image_Error::i()->argument(1, 'numeric');
            imagefilter($this->_resource, IMG_FILTER_BRIGHTNESS, $level);
            return $this;
        }

        public function colorize($red, $blue, $green, $alpha = 0)
        {
            Eden_Image_Error::i()->argument(1, 'numeric')->argument(2, 'numeric')->argument(3, 'numeric')->argument(4, 'numeric');
            imagefilter($this->_resource, IMG_FILTER_COLORIZE, $red, $blue, $green, $alpha);
            return $this;
        }

        public function contrast($level)
        {
            Eden_Image_Error::i()->argument(1, 'numeric');
            imagefilter($this->_resource, IMG_FILTER_CONTRAST, $level);
            return $this;
        }

        public function crop($width = NULL, $height = NULL)
        {
            Eden_Image_Error::i()->argument(1, 'numeric', 'null')->argument(2, 'numeric', 'null');
            $orgWidth = imagesx($this->_resource);
            $orgHeight = imagesy($this->_resource);
            if (is_null($width)) {
                $width = $orgWidth;
            }
            if (is_null($height)) {
                $height = $orgHeight;
            }
            if ($width == $orgWidth && $height == $orgHeight) {
                return $this;
            }
            $crop = imagecreatetruecolor($width, $height);
            $xPosition = 0;
            $yPosition = 0;
            if ($width > $orgWidth || $height > $orgHeight) {
                $newWidth = $width;
                $newHeight = $height;
                if ($height > $width) {
                    $height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
                    if ($newHeight > $height) {
                        $height = $newHeight;
                        $width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
                        $rWidth = $this->_getWidthAspectRatio($newWidth, $newHeight, $orgHeight);
                        $xPosition = ($orgWidth / 2) - ($rWidth / 2);
                    } else {
                        $rHeight = $this->_getHeightAspectRatio($newWidth, $newHeight, $orgWidth);
                        $yPosition = ($orgHeight / 2) - ($rHeight / 2);
                    }
                } else {
                    $width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
                    if ($newWidth > $width) {
                        $width = $newWidth;
                        $height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
                        $rHeight = $this->_getHeightAspectRatio($newWidth, $newHeight, $orgWidth);
                        $yPosition = ($orgHeight / 2) - ($rHeight / 2);
                    } else {
                        $rWidth = $this->_getWidthAspectRatio($newWidth, $newHeight, $orgHeight);
                        $xPosition = ($orgWidth / 2) - ($rWidth / 2);
                    }
                }
            } else {
                if ($width < $orgWidth) {
                    $xPosition = ($orgWidth / 2) - ($width / 2);
                    $width = $orgWidth;
                }
                if ($height < $orgHeight) {
                    $yPosition = ($orgHeight / 2) - ($height / 2);
                    $height = $orgHeight;
                }
            }
            imagecopyresampled($crop, $this->_resource, 0, 0, $xPosition, $yPosition, $width, $height, $orgWidth, $orgHeight);
            imagedestroy($this->_resource);
            $this->_resource = $crop;
            return $this;
        }

        public function edgedetect()
        {
            imagefilter($this->_resource, IMG_FILTER_EDGEDETECT);
            return $this;
        }

        public function emboss()
        {
            imagefilter($this->_resource, IMG_FILTER_EMBOSS);
            return $this;
        }

        public function gaussianBlur()
        {
            imagefilter($this->_resource, IMG_FILTER_GAUSSIAN_BLUR);
            return $this;
        }

        public function getDimensions()
        {
            return array(imagesx($this->_resource), imagesy($this->_resource));
        }

        public function getResource()
        {
            return $this->_resource;
        }

        public function greyscale()
        {
            imagefilter($this->_resource, IMG_FILTER_GRAYSCALE);
            return $this;
        }

        public function invert($vertical = false)
        {
            Eden_Image_Error::i()->argument(1, 'bool');
            $orgWidth = imagesx($this->_resource);
            $orgHeight = imagesy($this->_resource);
            $invert = imagecreatetruecolor($orgWidth, $orgHeight);
            if ($vertical) {
                imagecopyresampled($invert, $this->_resource, 0, 0, 0, ($orgHeight - 1), $orgWidth, $orgHeight, $orgWidth, 0 - $orgHeight);
            } else {
                imagecopyresampled($invert, $this->_resource, 0, 0, ($orgWidth - 1), 0, $orgWidth, $orgHeight, 0 - $orgWidth, $orgHeight);
            }
            imagedestroy($this->_resource);
            $this->_resource = $invert;
            return $this;
        }

        public function meanRemoval()
        {
            imagefilter($this->_resource, IMG_FILTER_MEAN_REMOVAL);
            return $this;
        }

        public function negative()
        {
            imagefilter($this->_resource, IMG_FILTER_NEGATE);
            return $this;
        }

        public function resize($width = NULL, $height = NULL)
        {
            Eden_Image_Error::i()->argument(1, 'numeric', 'null')->argument(2, 'numeric', 'null');
            $orgWidth = imagesx($this->_resource);
            $orgHeight = imagesy($this->_resource);
            if (is_null($width)) {
                $width = $orgWidth;
            }
            if (is_null($height)) {
                $height = $orgHeight;
            }
            if ($width == $orgWidth && $height == $orgHeight) {
                return $this;
            }
            $newWidth = $width;
            $newHeight = $height;
            if ($height < $width) {
                $width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
                if ($newWidth < $width) {
                    $width = $newWidth;
                    $height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
                }
            } else {
                $height = $this->_getHeightAspectRatio($orgWidth, $orgHeight, $width);
                if ($newHeight < $height) {
                    $height = $newHeight;
                    $width = $this->_getWidthAspectRatio($orgWidth, $orgHeight, $height);
                }
            }
            return $this->scale($width, $height);
        }

        public function rotate($degree, $background = 0)
        {
            Eden_Image_Error::i()->argument(1, 'numeric')->argument(2, 'numeric');
            $rotate = imagerotate($this->_resource, $degree, $background);
            imagedestroy($this->_resource);
            $this->_resource = $rotate;
            return $this;
        }

        public function scale($width = NULL, $height = NULL)
        {
            Eden_Image_Error::i()->argument(1, 'numeric', 'null')->argument(2, 'numeric', 'null');
            $orgWidth = imagesx($this->_resource);
            $orgHeight = imagesy($this->_resource);
            if (is_null($width)) {
                $width = $orgWidth;
            }
            if (is_null($height)) {
                $height = $orgHeight;
            }
            if ($width == $orgWidth && $height == $orgHeight) {
                return $this;
            }
            $scale = imagecreatetruecolor($width, $height);
            imagecopyresampled($scale, $this->_resource, 0, 0, 0, 0, $width, $height, $orgWidth, $orgHeight);
            imagedestroy($this->_resource);
            $this->_resource = $scale;
            return $this;
        }

        public function setTransparency()
        {
            imagealphablending($this->_resource, false);
            imagesavealpha($this->_resource, true);
            return $this;
        }

        public function smooth($level)
        {
            Eden_Image_Error::i()->argument(1, 'numeric');
            imagefilter($this->_resource, IMG_FILTER_SMOOTH, $level);
            return $this;
        }

        public function save($path, $type = NULL)
        {
            if (!$type) {
                $type = $this->_type;
            }
            switch ($type) {
                case 'gif':
                    imagegif($this->_resource, $path);
                    break;
                case 'png':
                    $quality = (100 - $this->_quality) / 10;
                    if ($quality > 9) {
                        $quality = 9;
                    }
                    imagepng($this->_resource, $path, $quality);
                    break;
                case 'bmp':
                case 'wbmp':
                    imagewbmp($this->_resource, $path, $this->_quality);
                    break;
                case 'jpg':
                case 'jpeg':
                case 'pjpeg':
                default:
                    imagejpeg($this->_resource, $path, $this->_quality);
                    break;
            }
            return $this;
        }

        protected function _getHeightAspectRatio($sourceWidth, $sourceHeight, $destinationWidth)
        {
            $ratio = $destinationWidth / $sourceWidth;
            return $sourceHeight * $ratio;
        }

        protected function _getResource($data, $path)
        {
            if (!function_exists('gd_info')) {
                Eden_Image_Error::i(Eden_Image_Error::GD_NOT_INSTALLED)->trigger();
            }
            $resource = false;
            if (!$path) {
                return imagecreatefromstring($data);
            }
            switch ($this->_type) {
                case 'gd':
                    $resource = imagecreatefromgd($data);
                    break;
                case 'gif':
                    $resource = imagecreatefromgif($data);
                    break;
                case 'jpg':
                case 'jpeg':
                case 'pjpeg':
                    $resource = imagecreatefromjpeg($data);
                    break;
                case 'png':
                    $resource = imagecreatefrompng($data);
                    break;
                case 'bmp':
                case 'wbmp':
                    $resource = imagecreatefromwbmp($data);
                    break;
                case 'xbm':
                    $resource = imagecreatefromxbm($data);
                    break;
                case 'xpm':
                    $resource = imagecreatefromxpm($data);
                    break;
            }
            if (!$resource) {
                Eden_Image_Error::i()->setMessage(Eden_Image_Error::NOT_VALID_IMAGE_FILE)->addVariable($path);
            }
            return $resource;
        }

        protected function _getWidthAspectRatio($sourceWidth, $sourceHeight, $destinationHeight)
        {
            $ratio = $destinationHeight / $sourceHeight;
            return $sourceWidth * $ratio;
        }
    }

    class Eden_Image_Error extends Eden_Error
    {
        const GD_NOT_INSTALLED = 'PHP GD Library is not installed.';
        const NOT_VALID_IMAGE_FILE = '%s is not a valid image file.';
        const NOT_STRING_MODEL = 'Argument %d is expecting a string or Eden_Image_Model.';
    }
}
/* Eden_Unit */
if (!class_exists('Eden_Unit')) {
    class Eden_Unit
    {
        protected $_last = array();
        protected $_start = 0;
        protected $_end = 0;
        protected $_report = array();
        protected $_package = 'main';

        public static function i()
        {
            $class = __CLASS__;
            return new $class();
        }

        public function __construct()
        {
            $this->_start = time();
        }

        public function __destruct()
        {
            $this->_end = time();
        }

        public function __call($name, $args)
        {
            if (method_exists($this, '_' . $name)) {
                $method = '_' . $name;
                $message = array_pop($args);
                $test = array('name' => $name, 'start' => isset($this->_last['end']) ? $this->_last['end'] : $this->_start, 'message' => $message);
                try {
                    $test['pass'] = call_user_func_array(array(&$this, $method), $args);
                } catch (Exception $e) {
                    $test['pass'] = false;
                    $test['error'] = array(get_class($e), $e->getMessage());
                }
                $test['end'] = time();
                $test['trace'] = debug_backtrace();
                $this->_report[$this->_package][] = $this->_last = $test;
                return $this;
            }
        }

        public function getPassFail($package = NULL)
        {
            Eden_Unit_Error::i()->argument(1, 'string', 'null');
            $passFail = array(0, 0);
            if (isset($this->_report[$package])) {
                foreach ($this->_report[$package] as $test) {
                    if ($test['pass']) {
                        $passFail[0]++;
                        continue;
                    }
                    $passFail[1]++;
                }
                return $passFail;
            }
            foreach ($this->_report as $package => $tests) {
                $packagePassFail = $this->getPassFail($package);
                $passFail[0] += $packagePassFail[0];
                $passFail[1] += $packagePassFail[1];
            }
            return $passFail;
        }

        public function getReport()
        {
            return $this->_report;
        }

        public function getTotalTests($package = NULL)
        {
            Eden_Unit_Error::i()->argument(1, 'string', 'null');
            if (isset($this->_report[$package])) {
                return count($this->_report[$package]);
            }
            $total = 0;
            foreach ($this->_report as $package => $tests) {
                $total += $tests;
            }
            return $tests;
        }

        public function setPackage($name)
        {
            Eden_Unit_Error::i()->argument(1, 'string');
            $this->_package = $name;
            return $this;
        }

        protected function _assertArrayHasKey($needle, $haystack)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'array');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return array_key_exists($needle, $haystack);
        }

        protected function _assertClassHasAttribute($needle, $haystack)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'object', 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return property_exists($needle, $haystack);
        }

        protected function _assertContains($needle, $haystack)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'array', 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            if (is_string($haystack)) {
                return strstr($haystack, $needle) !== false;
            }
            return in_array($needle, $haystack);
        }

        protected function _assertContainsOnly($type, $haystack)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'object', 'array');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            $method = 'is_' . $type;
            if (function_exists($method)) {
                foreach ($haystack as $needle) {
                    if (!$method($needle)) {
                        return false;
                    }
                }
                return true;
            }
            if (class_exists($type)) {
                foreach ($haystack as $needle) {
                    if (get_class($needle) != $type) {
                        return false;
                    }
                }
                return true;
            }
            return false;
        }

        protected function _assertCount($number, $haystack)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'int')->argument(2, 'array', 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            if (is_string($haystack)) {
                return strlen($haystack) == $number;
            }
            return count($haystack) == $number;
        }

        protected function _assertEmpty($actual)
        {
            return empty($actual);
        }

        protected function _assertEquals($expected, $actual)
        {
            return $expected === $actual;
        }

        protected function _assertFalse($condition)
        {
            return $condition === false;
        }

        protected function _assertGreaterThan($number, $actual)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'numeric')->argument(2, 'numeric');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return $actual > $number;
        }

        protected function _assertGreaterThanOrEqual($number, $actual)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'numeric')->argument(2, 'numeric');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return $actual >= $number;
        }

        protected function _assertInstanceOf($expected, $actual)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'object');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return $actual instanceof $expected;
        }

        protected function _assertInternalType($type, $actual)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            $method = 'is_' . $type;
            if (function_exists($method)) {
                return !$method($actual);
            }
            if (class_exists($type)) {
                return get_class($actual) != $type;
            }
            return false;
        }

        protected function _assertLessThan($number, $actual)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'numeric')->argument(2, 'numeric');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return $actual < $number;
        }

        protected function _assertLessThanOrEqual($number, $actual)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'numeric')->argument(2, 'numeric');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return $actual <= $number;
        }

        protected function _assertNull($mixed)
        {
            return is_null($mixed);
        }

        protected function _assertRegExp($pattern, $string)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return preg_match($pattern, $string);
        }

        protected function _assertSame($expected, $actual)
        {
            return $expected == $actual;
        }

        protected function _assertStringEndsWith($suffix, $string)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return substr_compare($string, $suffix, -strlen($suffix), strlen($suffix)) === 0;
        }

        protected function _assertStringStartsWith($prefix, $string)
        {
            try {
                Eden_Unit_Error::i()->argument(1, 'string')->argument(2, 'string');
            } catch (Eden_Unit_Error $e) {
                return false;
            }
            return strpos($string, $prefix) === 0;
        }

        protected function _assertTrue($condition)
        {
            return $condition === true;
        }
    }

    class Eden_Unit_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Timezone_Error */
if (!class_exists('Eden_Timezone_Error')) {
    class Eden_Timezone_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }

        protected function _isValid($type, $data)
        {
            $valid = Eden_Timezone_Validation::i();
            switch ($type) {
                case 'location':
                    return $valid->isLocation($data);
                case 'utc':
                    return $valid->isUtc($data);
                case 'abbr':
                    return $valid->isAbbr($data);
                default:
                    break;
            }
            return parent::_isValid($type, $data);
        }
    }
}
/* Eden_Timezone_Validation */
if (!class_exists('Eden_Timezone_Validation')) {
    class Eden_Timezone_Validation extends Eden_Class
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function isAbbr($value)
        {
            return preg_match('/^[A-Z]{1,5}$/', $value);
        }

        public function isLocation($value)
        {
            return in_array($value, DateTimeZone::listIdentifiers());
        }

        public function isUtc($value)
        {
            return preg_match('/^(GMT|UTC){0,1}(\-|\+)[0-9]{1,2}(\:{0,1}[0-9]{2}){0,1}$/', $value);
        }
    }
}
/* Eden_Timezone */
if (!class_exists('Eden_Timezone')) {
    class Eden_Timezone extends Eden_Class
    {
        const GMT = 'GMT';
        const UTC = 'UTC';

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($zone, $time = NULL)
        {
            Eden_Timezone_Error::i()->argument(1, 'string')->argument(1, 'location', 'utc', 'abbr')->argument(2, 'int', 'string', 'null');
            if (is_null($time)) {
                $time = time();
            }
            $this->_offset = $this->_getOffset($zone);
            $this->setTime($time);
        }

        public function convertTo($zone, $format = NULL)
        {
            Eden_Timezone_Error::i()->argument(1, 'string')->argument(1, 'location', 'utc', 'abbr')->argument(2, 'string', 'null');
            $time = $this->_time + $this->_getOffset($zone);
            if (!is_null($format)) {
                return date($format, $time);
            }
            return $time;
        }

        public function getGMT($prefix = self::GMT)
        {
            Eden_Timezone_Error::i()->argument(1, 'string');
            list($hour, $minute, $sign) = $this->_getUtcParts($this->_offset);
            return $prefix . $sign . $hour . $minute;
        }

        public function getGMTDates($format, $interval = 30, $prefix = self::GMT)
        {
            Eden_Timezone_Error::i()->argument(1, 'string')->argument(2, 'int')->argument(3, 'string', 'null');
            $offsets = $this->getOffsetDates($format, $interval);
            $dates = array();
            foreach ($offsets as $offset => $date) {
                list($hour, $minute, $sign) = $this->_getUtcParts($offset);
                $gmt = $prefix . $sign . $hour . $minute;
                $dates[$gmt] = $date;
            }
            return $dates;
        }

        public function getOffset()
        {
            return $this->_offset;
        }

        public function getOffsetDates($format, $interval = 30)
        {
            Eden_Timezone_Error::i()->argument(1, 'string')->argument(2, 'int');
            $dates = array();
            $interval *= 60;
            for ($i = -12 * 3600; $i <= (12 * 3600); $i += $interval) {
                $time = $this->_time + $i;
                $dates[$i] = date($format, $time);
            }
            return $dates;
        }

        public function getTime($format = NULL)
        {
            Eden_Timezone_Error::i()->argument(1, 'string', 'null');
            $time = $this->_time + $this->_offset;
            if (!is_null($format)) {
                return date($format, $time);
            }
            return $time;
        }

        public function getUTC($prefix = self::UTC)
        {
            Eden_Timezone_Error::i()->argument(1, 'string');
            list($hour, $minute, $sign) = $this->_getUtcParts($this->_offset);
            return $prefix . $sign . $hour . ':' . $minute;
        }

        public function getUTCDates($format, $interval = 30, $prefix = self::UTC)
        {
            Eden_Timezone_Error::i()->argument(1, 'string')->argument(2, 'int')->argument(3, 'string', 'null');
            $offsets = $this->getOffsetDates($format, $interval);
            $dates = array();
            foreach ($offsets as $offset => $date) {
                list($hour, $minute, $sign) = $this->_getUtcParts($offset);
                $utc = $prefix . $sign . $hour . ':' . $minute;
                $dates[$utc] = $date;
            }
            return $dates;
        }

        public function setTime($time)
        {
            Eden_Timezone_Error::i()->argument(1, 'int', 'string');
            if (is_string($time)) {
                $time = strtotime($time);
            }
            $this->_time = $time - $this->_offset;
            return $this;
        }

        public function validation()
        {
            return Eden_Timezone_Validation::i();
        }

        protected function _getOffset($zone)
        {
            if ($this->validation()->isLocation($zone)) {
                return $this->_getOffsetFromLocation($zone);
            }
            if ($this->validation()->isUtc($zone)) {
                return $this->_getOffsetFromUtc($zone);
            }
            if ($this->validation()->isAbbr($zone)) {
                return $this->_getOffsetFromAbbr($zone);
            }
            return 0;
        }

        protected function _getOffsetFromAbbr($zone)
        {
            $zone = timezone_name_from_abbr(strtolower($zone));
            return $this->_getOffsetFromLocation($zone);
        }

        protected function _getOffsetFromLocation($zone)
        {
            $zone = new DateTimeZone($zone);
            $gmt = new DateTimeZone(self::GMT);
            return $zone->getOffset(new DateTime('now', $gmt));
        }

        protected function _getOffsetFromUtc($zone)
        {
            $zone = str_replace(array('GMT', 'UTC'), '', $zone);
            $zone = str_replace(':', '', $zone);
            $add = $zone[0] == '+';
            $zone = substr($zone, 1);
            switch (strlen($zone)) {
                case 1:
                case 2:
                    return $zone * 3600 * ($add ? 1 : -1);
                case 3:
                    $hour = substr($zone, 0, 1) * 3600;
                    $minute = substr($zone, 1) * 60;
                    return ($hour + $minute) * ($add ? 1 : -1);
                case 4:
                    $hour = substr($zone, 0, 2) * 3600;
                    $minute = substr($zone, 2) * 60;
                    return ($hour + $minute) * ($add ? 1 : -1);
            }
            return 0;
        }

        private function _getUtcParts($offset)
        {
            $minute = '0' . (floor(abs($offset / 60)) % 60);
            return array(floor(abs($offset / 3600)), substr($minute, strlen($minute) - 2), $offset < 0 ? '-' : '+');
        }
    }
}
/* Eden_Country_Error */
if (!class_exists('Eden_Country_Error')) {
    class Eden_Country_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Country_Au */
if (!class_exists('Eden_Country_Au')) {
    class Eden_Country_Australia extends Eden_Class
    {
        protected static $_territories = array('Australian Capital Territory', 'New South Wales', 'Northern Territory', 'Queensland', 'South Australia', 'Tasmania', 'Victoria', 'Western Australia');

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function getTerritories()
        {
            return self::$_territories;
        }
    }
}
/* Eden_Country_Ca */
if (!class_exists('Eden_Country_Ca')) {
    class Eden_Country_Ca extends Eden_Class
    {
        protected static $_territories = array('BC' => 'British Columbia', 'ON' => 'Ontario', 'NL' => 'Newfoundland and Labrador', 'NS' => 'Nova Scotia', 'PE' => 'Prince Edward Island', 'NB' => 'New Brunswick', 'QC' => 'Quebec', 'MB' => 'Manitoba', 'SK' => 'Saskatchewan', 'AB' => 'Alberta', 'NT' => 'Northwest Territories', 'NU' => 'Nunavut', 'YT' => 'Yukon Territory');

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function getTerritories()
        {
            return self::$_territories;
        }
    }
}
/* Eden_Country_Uk */
if (!class_exists('Eden_Country_Uk')) {
    class Eden_Country_Uk extends Eden_Class
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function getCounties()
        {
            return self::$_counties;
        }

        protected static $_counties = array('Aberdeenshire', 'Alderney', 'Angus/Forfarshire', 'Argyllshire', 'Avon', 'Ayrshire', 'Banffshire', 'Bedfordshire', 'Berkshire', 'Berwickshire', 'Buckinghamshire', 'Buteshire', 'Caithness', 'Cambridgeshire', 'Cheshire', 'Clackmannanshire', 'Clwyd', 'Cornwall', 'County Antrim', 'County Armagh', 'County Down', 'County Fermanagh', 'County Londonderry', 'County Tyrone', 'Cumbria', 'Derbyshire', 'Devon', 'Dorset', 'Dumbartonshire', 'Dumfriesshire', 'Durham', 'Dyfed', 'East Lothian', 'East Sussex', 'East Yorkshire', 'Essex', 'Fair Isle', 'Fife', 'Gloucestershire', 'Greater London', 'Greater Manchester', 'Guernsey', 'Gwent', 'Gwynedd', 'Hampshire', 'Herefordshire', 'Herm', 'Hertfordshire', 'Huntingdonshire', 'Inner Hebrides', 'Inverness-shire', 'Isle of Man', 'Isle of Wight', 'Isles of Scilly', 'Jersey', 'Kent', 'Kincardineshire', 'Kinross-shire', 'Kirkcudbrightshire', 'Lanarkshire', 'Lancashire', 'Leicestershire', 'Lincolnshire', 'Merseyside', 'Mid Glamorgan', 'Middlesex', 'Midlothian/Edinburghshire', 'Morayshire', 'Nairnshire', 'Norfolk', 'North Yorkshire', 'Northamptonshire', 'Northumberland', 'Nottinghamshire', 'Orkney', 'Outer Hebrides', 'Oxfordshire', 'Peeblesshire', 'Perthshire', 'Powys', 'Renfrewshire', 'Ross-shire', 'Roxburghshire', 'Rutland', 'Sark', 'Selkirkshire', 'Shetland', 'Shropshire', 'Somerset', 'South Glamorgan', 'South Yorkshire', 'Staffordshire', 'Stirlingshire', 'Suffolk', 'Surrey', 'Sutherland', 'Tyne and Wear', 'Warwickshire', 'West Glamorgan', 'West Lothian/Linlithgowshire', 'West Midlands', 'West Sussex', 'West Yorkshire', 'Wigtownshire', 'Wiltshire', 'Worcestershire');
    }
}
/* Eden_Country_Us */
if (!class_exists('Eden_Country_Us')) {
    class Eden_Country_Us extends Eden_Class
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function getStateFromPostal($postal)
        {
            Eden_Country_Error::i()->argument(1, 'int');
            if (strlen((string)$postal) < 5) {
                return false;
            }
            for ($i = 0; $i < count(self::$_codes); $i++) {
                if ($postal < substr(self::$_codes[$i], 2, 5) || $postal > substr(self::$_codes[$i], 7, 5)) {
                    continue;
                }
                return substr(self::$_codes[$i], 0, 2);
            }
            return false;
        }

        public function getStates()
        {
            return self::$_states;
        }

        public function getTerritories()
        {
            return self::$_territories;
        }

        protected static $_codes = array('AK9950099929', 'AL3500036999', 'AR7160072999', 'AR7550275505', 'AZ8500086599', 'CA9000096199', 'CO8000081699', 'CT0600006999', 'DC2000020099', 'DC2020020599', 'DE1970019999', 'FL3200033999', 'FL3410034999', 'GA3000031999', 'HI9670096798', 'HI9680096899', 'IA5000052999', 'ID8320083899', 'IL6000062999', 'IN4600047999', 'KS6600067999', 'KY4000042799', 'KY4527545275', 'LA7000071499', 'LA7174971749', 'MA0100002799', 'MD2033120331', 'MD2060021999', 'ME0380103801', 'ME0380403804', 'ME0390004999', 'MI4800049999', 'MN5500056799', 'MO6300065899', 'MS3860039799', 'MT5900059999', 'NC2700028999', 'ND5800058899', 'NE6800069399', 'NH0300003803', 'NH0380903899', 'NJ0700008999', 'NM8700088499', 'NV8900089899', 'NY0040000599', 'NY0639006390', 'NY0900014999', 'OH4300045999', 'OK7300073199', 'KY7340074999', 'OR9700097999', 'PA1500019699', 'RI0280002999', 'RI0637906379', 'SC2900029999', 'SD5700057799', 'TN3700038599', 'TN7239572395', 'TX7330073399', 'TX7394973949', 'TX7500079999', 'TX8850188599', 'UT8400084799', 'VA2010520199', 'VA2030120301', 'VA2037020370', 'VA2200024699', 'VT0500005999', 'WA9800099499', 'WI4993649936', 'WI5300054999', 'WV2470026899', 'WY8200083199');
        protected static $_states = array('AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District Of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming');
        protected static $_territories = array('AS' => 'American Samoa', 'FM' => 'Federated States of Micronesia', 'GU' => 'Guam', 'MH' => 'Marshall Islands', 'MP' => 'Northern Mariana Islands', 'PW' => 'Palau', 'PR' => 'Puerto Rico', 'VI' => 'Virgin Islands', 'AE' => 'Armed Forces', 'AA' => 'Armed Forces Americas', 'AP' => 'Armed Forces Pacific');
    }
}
/* Eden_Country */
if (!class_exists('Eden_Country')) {
    class Eden_Country extends Eden_Class
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function au()
        {
            return Eden_Country_Au::i();
        }

        public function ca()
        {
            return Eden_Country_Ca::i();
        }

        public function getList()
        {
            return self::$_countries;
        }

        public function uk()
        {
            return Eden_Country_Uk::i();
        }

        public function us()
        {
            return Eden_Country_Us::i();
        }

        protected static $_countries = array('GB' => 'United Kingdom', 'US' => 'United States', 'AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia And Herzegowina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo,The Democratic Republic Of The', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'Ivoire', 'HR' => 'Croatia (Local Name: Hrvatska)', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'TP' => 'East Timor', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'FX' => 'France,Metropolitan', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard And Mc Donald Islands', 'VA' => 'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran (Islamic Republic Of)', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'Korea,Democratic People\'s Republic Of', 'KR' => 'Korea,Republic Of', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macau', 'MK' => 'Macedonia,Former Yugoslav Republic Of', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia,Federated States Of', 'MD' => 'Moldova,Republic Of', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'VC' => 'Saint Vincent And The Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia (Slovak Republic)', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia,South Sandwich Islands', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SH' => 'St.Helena', 'PM' => 'St.Pierre And Miquelon', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen Islands', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania,United Republic Of', 'TH' => 'Thailand', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'UM' => 'United States Minor Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands (British)', 'VI' => 'Virgin Islands (U.S.)', 'WF' => 'Wallis And Futuna Islands', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'YU' => 'Yugoslavia', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe');
    }
}
/* Eden_Language */
if (!class_exists('Eden_Language')) {
    class Eden_Language extends Eden_Class implements ArrayAccess, Iterator
    {
        protected $_language = array();
        protected $_file = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($language = array())
        {
            Eden_Language_Error::i()->argument(1, 'file', 'array');
            if (is_string($language)) {
                $this->_file = $language;
                $language = include($language);
            }
            $this->_language = $language;
        }

        public function current()
        {
            return current($this->_language);
        }

        public function get($key)
        {
            Eden_Language_Error::i()->argument(1, 'string');
            if (!isset($this->_language[$key])) {
                $this->_language[$key] = $key;
            }
            return $this->_language[$key];
        }

        public function getLanguage()
        {
            return $this->_language;
        }

        public function key()
        {
            return key($this->_language);
        }

        public function next()
        {
            next($this->_language);
        }

        public function offsetExists($offset)
        {
            return isset($this->_language[$offset]);
        }

        public function offsetGet($offset)
        {
            return $this->get($offset);
        }

        public function offsetSet($offset, $value)
        {
            $this->translate($offset, $value);
        }

        public function offsetUnset($offset)
        {
            unset($this->_language[$offset]);
        }

        public function rewind()
        {
            reset($this->_language);
        }

        public function save($file = NULL)
        {
            Eden_Language_Error::i()->argument(1, 'file', 'null');
            if (is_null($file)) {
                $file = $this->_file;
            }
            if (is_null($file)) {
                Eden_Language_Error::i()->setMessage(Eden_Language_Error::INVALID_ARGUMENT)->addVariable(1)->addVariable(__CLASS__ . '->' . __FUNCTION__)->addVariable('file or null')->addVariable($file)->setTypeLogic()->trigger();
            }
            Eden_File::i($file)->setData($this->_language);
            return $this;
        }

        public function translate($key, $value)
        {
            Eden_Language_Error::i()->argument(1, 'string')->argument(2, 'string');
            $this->_language[$key] = $value;
            return $this;
        }

        public function valid()
        {
            return isset($this->_language[key($this->_language)]);
        }
    }

    class Eden_Language_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Oauth_Error */
if (!class_exists('Eden_Oauth_Error')) {
    class Eden_Oauth_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Oauth_Base */
if (!class_exists('Eden_Oauth_Base')) {
    class Eden_Oauth_Base extends Eden_Class
    {
        const HMAC_SHA1 = 'HMAC-SHA1';
        const RSA_SHA1 = 'RSA-SHA1';
        const PLAIN_TEXT = 'PLAINTEXT';
        const POST = 'POST';
        const GET = 'GET';
        const DELETE = 'DELETE';
        const OAUTH_VERSION = '1.0';

        protected function _buildQuery($params, $separator = '&', $noQuotes = true, $subList = false)
        {
            if (empty($params)) {
                return '';
            }
            $keys = $this->_encode(array_keys($params));
            $values = $this->_encode(array_values($params));
            $params = array_combine($keys, $values);
            uksort($params, 'strcmp');
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    natsort($value);
                    $params[$key] = $this->_buildQuery($value, $separator, $noQuotes, true);
                    continue;
                }
                if (!$noQuotes) {
                    $value = '"' . $value . '"';
                }
                $params[$key] = $value;
            }
            if ($subList) {
                return $params;
            }
            foreach ($params as $key => $value) {
                $params[$key] = $key . '=' . $value;
            }
            return implode($separator, $params);
        }

        protected function _encode($string)
        {
            if (is_array($string)) {
                foreach ($string as $i => $value) {
                    $string[$i] = $this->_encode($value);
                }
                return $string;
            }
            if (is_scalar($string)) {
                return str_replace('%7E', '~', rawurlencode($string));
            }
            return NULL;
        }

        protected function _decode($raw_input)
        {
            return rawurldecode($raw_input);
        }

        protected function _parseString($string)
        {
            $array = array();
            if (strlen($string) < 1) {
                return $array;
            }
            $keyvalue = explode('&', $query_string);
            foreach ($keyvalue as $pair) {
                list($k, $v) = explode('=', $pair, 2);
                if (isset($query_array[$k])) {
                    if (is_scalar($query_array[$k])) {
                        $query_array[$k] = array($query_array[$k]);
                    }
                    array_push($query_array[$k], $v);
                } else {
                    $query_array[$k] = $v;
                }
            }
            return $array;
        }
    }
}
/* Eden_Oauth_Consumer */
if (!class_exists('Eden_Oauth_Consumer')) {
    class Eden_Oauth_Consumer extends Eden_Oauth_Base
    {
        const AUTH_HEADER = 'Authorization: OAuth %s';
        const POST_HEADER = 'Content-Type: application/x-www-form-urlencoded';
        protected $_consumerKey = NULL;
        protected $_consumerSecret = NULL;
        protected $_requestToken = NULL;
        protected $_requestSecret = NULL;
        protected $_useAuthorization = false;
        protected $_url = NULL;
        protected $_method = NULL;
        protected $_realm = NULL;
        protected $_time = NULL;
        protected $_nonce = NULL;
        protected $_verifier = NULL;
        protected $_callback = NULL;
        protected $_signature = NULL;
        protected $_meta = array();
        protected $_headers = array();
        protected $_json = false;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($url, $key, $secret)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string');
            $this->_consumerKey = $key;
            $this->_consumerSecret = $secret;
            $this->_url = $url;
            $this->_time = time();
            $this->_nonce = md5(uniqid(rand(), true));
            $this->_signature = self::PLAIN_TEXT;
            $this->_method = self::GET;
        }

        public function getAuthorization($signature, $string = true)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'bool');
            $params = array('realm' => $this->_realm, 'oauth_consumer_key' => $this->_consumerKey, 'oauth_token' => $this->_requestToken, 'oauth_signature_method' => self::HMAC_SHA1, 'oauth_signature' => $signature, 'oauth_timestamp' => $this->_time, 'oauth_nonce' => $this->_nonce, 'oauth_version' => self::OAUTH_VERSION, 'oauth_verifier' => $this->_verifier, 'oauth_callback' => $this->_callback);
            if (is_null($this->_realm)) {
                unset($params['realm']);
            }
            if (is_null($this->_requestToken)) {
                unset($params['oauth_token']);
            }
            if (is_null($this->_verifier)) {
                unset($params['oauth_verifier']);
            }
            if (is_null($this->_callback)) {
                unset($params['oauth_callback']);
            }
            if (!$string) {
                return $params;
            }
            return sprintf(self::AUTH_HEADER, $this->_buildQuery($params, ',', false));
        }

        public function getDomDocumentResponse(array $query = array())
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->getResponse($query));
            return $xml;
        }

        public function getHmacPlainTextSignature()
        {
            return $this->_consumerSecret . '&' . $this->_tokenSecret;
        }

        public function getHmacSha1Signature(array $query = array())
        {
            $params = array('oauth_consumer_key' => $this->_consumerKey, 'oauth_token' => $this->_requestToken, 'oauth_signature_method' => self::HMAC_SHA1, 'oauth_timestamp' => $this->_time, 'oauth_nonce' => $this->_nonce, 'oauth_version' => self::OAUTH_VERSION, 'oauth_verifier' => $this->_verifier, 'oauth_callback' => $this->_callback);
            if (is_null($this->_requestToken)) {
                unset($params['oauth_token']);
            }
            if (is_null($this->_verifier)) {
                unset($params['oauth_verifier']);
            }
            if (is_null($this->_callback)) {
                unset($params['oauth_callback']);
            }
            $query = array_merge($params, $query);
            $query = $this->_buildQuery($query);
            $string = array($this->_method, $this->_encode($this->_url), $this->_encode($query));
            $string = implode('&', $string);
            $key = $this->_encode($this->_consumerSecret) . '&' . $this->_encode($this->_requestSecret);
            return base64_encode(hash_hmac('sha1', $string, $key, true));
        }

        public function getJsonResponse(array $query = array(), $assoc = true)
        {
            return json_decode($this->getResponse($query), $assoc);
        }

        public function getMeta($key = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string', 'null');
            if (isset($this->_meta[$key])) {
                return $this->_meta[$key];
            }
            return $this->_meta;
        }

        public function getQueryResponse(array $query = array())
        {
            parse_str($this->getResponse($query), $response);
            return $response;
        }

        public function getResponse(array $query = array())
        {
            $headers = $this->_headers;
            $json = NULL;
            if ($this->_json) {
                $json = json_encode($query);
                $query = array();
            }
            $signature = $this->getSignature($query);
            $authorization = $this->getAuthorization($signature, false);
            if ($this->_useAuthorization) {
                $headers[] = sprintf(self::AUTH_HEADER, $this->_buildQuery($authorization, ',', false));
            } else {
                $query = array_merge($authorization, $query);
            }
            $query = $this->_buildQuery($query);
            $url = $this->_url;
            $curl = Eden_Curl::i()->verifyHost(false)->verifyPeer(false);
            if ($this->_method == self::POST) {
                $headers[] = self::POST_HEADER;
                if (!is_null($json)) {
                    $query = $json;
                }
                $response = $curl->setUrl($url)->setPost(true)->setPostFields($query)->setHeaders($headers)->getResponse();
            } else if ($this->_method == self::DELETE) {
                $response = $curl->setUrl($url)->setCustomRequest('DELETE')->setHeaders($headers)->getResponse();
            } else {
                if (trim($query)) {
                    $connector = NULL;
                    if (strpos($url, '?') === false) {
                        $connector = '?';
                    } else if (substr($url, -1) != '?') {
                        $connector = '&';
                    }
                    $url .= $connector . $query;
                }
                $response = $curl->setUrl($url)->setHeaders($headers)->getResponse();
            }
            $this->_meta = $curl->getMeta();
            $this->_meta['url'] = $url;
            $this->_meta['authorization'] = $authorization;
            $this->_meta['headers'] = $headers;
            $this->_meta['query'] = $query;
            $this->_meta['response'] = $response;
            return $response;
        }

        public function getSignature(array $query = array())
        {
            switch ($this->_signature) {
                case self::HMAC_SHA1:
                    return $this->getHmacSha1Signature($query);
                case self::RSA_SHA1:
                case self::PLAIN_TEXT:
                default:
                    return $this->getHmacPlainTextSignature();
            }
        }

        public function getSimpleXmlResponse(array $query = array())
        {
            return simplexml_load_string($this->getResponse($query));
        }

        public function jsonEncodeQuery()
        {
            $this->_json = true;
            return $this;
        }

        public function setCallback($url)
        {
            Eden_Oauth_Error::i()->argument(1, 'string');
            $this->_callback = $url;
            return $this;
        }

        public function setHeaders($key, $value = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'array', 'string')->argument(2, 'scalar', 'null');
            if (is_array($key)) {
                $this->_headers = $key;
                return $this;
            }
            $this->_headers[] = $key . ': ' . $value;
            return $this;
        }

        public function setMethodToGet()
        {
            $this->_method = self::GET;
            return $this;
        }

        public function setMethodToDelete()
        {
            $this->_method = self::DELETE;
            return $this;
        }

        public function setMethodToPost()
        {
            $this->_method = self::POST;
            return $this;
        }

        public function setRealm($realm)
        {
            Eden_Oauth_Error::i()->argument(1, 'string');
            $this->_realm = $realm;
            return $this;
        }

        public function setSignatureToHmacSha1()
        {
            $this->_signature = self::HMAC_SHA1;
            return $this;
        }

        public function setSignatureToRsaSha1()
        {
            $this->_signature = self::RSA_SHA1;
            return $this;
        }

        public function setSignatureToPlainText()
        {
            $this->_signature = self::PLAIN_TEXT;
            return $this;
        }

        public function setToken($token, $secret)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string');
            $this->_requestToken = $token;
            $this->_requestSecret = $secret;
            return $this;
        }

        public function setVerifier($verifier)
        {
            Eden_Oauth_Error::i()->argument(1, 'scalar');
            $this->_verifier = $verifier;
            return $this;
        }

        public function useAuthorization($use = true)
        {
            Eden_Oauth_Error::i()->argument(1, 'bool');
            $this->_useAuthorization = $use;
            return $this;
        }
    }
}
/* Eden_Oauth */
if (!class_exists('Eden_Oauth')) {
    class Eden_Oauth extends Eden_Class
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function consumer($url, $key, $secret)
        {
            return Eden_Oauth_Consumer::i($url, $key, $secret);
        }

        public function getHmacGetAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToGet()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getHmacGetAuthorizationAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToGet()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getHmacGetAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToGet()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getHmacGetRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToGet()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getHmacPostAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToPost()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getHmacPostAuthorizationAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToPost()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getHmacPostAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToPost()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getHmacPostRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToPost()->setSignatureToHmacSha1()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getPlainGetAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToGet()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getPlainGetAuthorizationAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToGet()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getPlainGetAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToGet()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getPlainGetRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToGet()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getPlainPostAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToPost()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getPlainPostAuthorizationAccessToken($url, $key, $secret, $token, $tokenSecret, array $query = array(), $realm = NULL, $verifier = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string')->argument(5, 'string')->argument(7, 'string', 'null')->argument(8, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToPost()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->when($verifier)->setVerifier($verifier)->endWhen()->setRequestToken($token, $tokenSecret)->getToken($query);
        }

        public function getPlainPostAuthorizationRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->useAuthorization()->setMethodToPost()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function getPlainPostRequestToken($url, $key, $secret, array $query = array(), $realm = NULL)
        {
            Eden_Oauth_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(5, 'string', 'null');
            return $this->consumer($url, $key, $secret)->setMethodToPost()->setSignatureToPlainText()->when($realm)->setRealm($realm)->endWhen()->getToken($query);
        }

        public function server()
        {
            return Eden_Oauth_Server::i();
        }
    }
}
/* Eden_Oauth2_Abstract */
if (!class_exists('Eden_Oauth2_Abstract')) {
    abstract class Eden_Oauth2_Abstract extends Eden_Class
    {
        const CODE = 'code';
        const TOKEN = 'token';
        const ONLINE = 'online';
        const OFFLINE = 'offline';
        const AUTO = 'auto';
        const FORCE = 'force';
        const TYPE = 'Content-Type';
        const REQUEST = 'application/x-www-form-urlencoded';
        const RESPONSE_TYPE = 'response_type';
        const CLIENT_ID = 'client_id';
        const REDIRECT_URL = 'redirect_uri';
        const ACCESS_TYPE = 'access_type';
        const APROVAL = 'approval_prompt';
        const CLIENT_SECRET = 'client_secret';
        const GRANT_TYPE = 'grant_type';
        const AUTHORIZATION = 'authorization_code';
        const REFRESH_TOKEN = 'refresh_token';
        protected $_client = NULL;
        protected $_meta = array();
        protected $_secret = NULL;
        protected $_redirect = NULL;
        protected $_state = NULL;
        protected $_scope = NULL;
        protected $_display = NULL;
        protected $_requestUrl = NULL;
        protected $_accessUrl = NULL;
        protected $_responseType = self::CODE;
        protected $_approvalPrompt = self::AUTO;

        public function __construct($client, $secret, $redirect, $requestUrl, $accessUrl)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'url')->argument(4, 'url')->argument(5, 'url');
            $this->_client = $client;
            $this->_secret = $secret;
            $this->_redirect = $redirect;
            $this->_requestUrl = $requestUrl;
            $this->_accessUrl = $accessUrl;
        }

        public function getMeta()
        {
            return $this->_meta;
        }

        public function autoApprove()
        {
            $this->_approvalPrompt = self::AUTO;
            return $this;
        }

        public function forceApprove()
        {
            $this->_approvalPrompt = self::FORCE;
            return $this;
        }

        public function setState($state)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string');
            $this->_state = $state;
            return $this;
        }

        public function setScope($scope)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string', 'array');
            $this->_scope = $scope;
            return $this;
        }

        public function setDisplay($display)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string', 'array');
            $this->_display = $display;
            return $this;
        }

        public function isJson($string)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string');
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }

        abstract public function getLoginUrl($scope = NULL, $display = NULL);

        abstract public function getAccess($code);

        protected function _getLoginUrl($query)
        {
            if (!is_null($this->_scope)) {
                if (is_array($this->_scope)) {
                    $this->_scope = implode(' ', $this->_scope);
                }
                $query['scope'] = $this->_scope;
            }
            if (!is_null($this->_state)) {
                $query['state'] = $this->_state;
            }
            if (!is_null($this->_display)) {
                $query['display'] = $this->_display;
            }
            return $this->_requestUrl . '?' . http_build_query($query);
        }

        protected function _getAccess($query, $code = NULL, $refreshToken)
        {
            if (!is_null($code)) {
                if ($refreshToken) {
                    $query[self::REFRESH_TOKEN] = $code;
                } else {
                    $query[self::CODE] = $code;
                }
            }
            $curl = Eden_Curl::i()->setUrl($this->_accessUrl)->verifyHost(false)->verifyPeer(false)->setHeaders(self::TYPE, self::REQUEST)->setPostFields(http_build_query($query));
            $result = $curl->getResponse();
            $this->_meta = $curl->getMeta();
            $this->_meta['query'] = $query;
            $this->_meta['url'] = $this->_accessUrl;
            $this->_meta['response'] = $result;
            if ($this->isJson($result)) {
                $response = json_decode($result, true);
            } else {
                parse_str($result, $response);
            }
            return $response;
        }
    }
}
/* Eden_Oauth2_Error */
if (!class_exists('Eden_Oauth2_Error')) {
    class Eden_Oauth2_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Oauth2_Client */
if (!class_exists('Eden_Oauth2_Client')) {
    class Eden_Oauth2_Client extends Eden_Oauth2_Abstract
    {
        protected $_responseType = self::CODE;
        protected $_accessType = self::ONLINE;
        protected $_approvalPrompt = self::FORCE;
        protected $_grantType = self::AUTHORIZATION;

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function forOffline()
        {
            $this->_accessType = self::OFFLINE;
            return $this;
        }

        public function forOnline()
        {
            $this->_accessType = self::ONLINE;
            return $this;
        }

        public function approvalPromptToAuto()
        {
            $this->_approvalPrompt = self::AUTO;
            return $this;
        }

        public function getLoginUrl($scope = NULL, $display = NULL)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string', 'array', 'null')->argument(2, 'string', 'array', 'null');
            if (!is_null($scope)) {
                $this->setScope($scope);
            }
            if (!is_null($display)) {
                $this->setDisplay($display);
            }
            $query = array(self::RESPONSE_TYPE => $this->_responseType, self::CLIENT_ID => $this->_client, self::REDIRECT_URL => $this->_redirect, self::ACCESS_TYPE => $this->_accessType, self::APROVAL => $this->_approvalPrompt);
            return $this->_getLoginUrl($query);
        }

        public function getAccess($code, $refreshToken = false)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string')->argument(2, 'bool');
            if ($refreshToken) {
                $query = array(self::CLIENT_ID => $this->_client, self::CLIENT_SECRET => $this->_secret, self::GRANT_TYPE => self::REFRESH_TOKEN);
            } else {
                $query = array(self::CLIENT_ID => $this->_client, self::CLIENT_SECRET => $this->_secret, self::REDIRECT_URL => $this->_redirect, self::GRANT_TYPE => $this->_grantType);
            }
            return $this->_getAccess($query, $code, $refreshToken);
        }
    }
}
/* Eden_Oauth2_Desktop */
if (!class_exists('Eden_Oauth2_Desktop')) {
    class Eden_Oauth2_Desktop extends Eden_Oauth2_Abstract
    {
        protected $_responseType = self::CODE;
        protected $_grantType = 'authorization_code';

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function getLoginUrl($scope = NULL, $display = NULL)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string', 'array', 'null')->argument(2, 'string', 'array', 'null');
            if (!is_null($scope)) {
                $this->setScope($scope);
            }
            if (!is_null($display)) {
                $this->setDisplay($display);
            }
            $query = array(self::RESPONSE_TYPE => $this->_responseType, self::CLIENT_ID => $this->_client, self::REDIRECT_URL => $this->_redirect);
            return $this->_getLoginUrl($query);
        }

        public function getAccess($code)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string');
            $query = array(self::CLIENT_ID => $this->_client, self::CLIENT_SECRET => $this->_secret, self::REDIRECT_URL => $this->_redirect, self::GRANT_TYPE => $this->_grantType);
            return $this->_getAccess($query, $code);
        }
    }
}
/* Eden_Oauth2 */
if (!class_exists('Eden_Oauth2')) {
    class Eden_Oauth2 extends Eden_Class
    {
        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function client($client, $secret, $redirect, $requestUrl, $accessUrl)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'url')->argument(4, 'url')->argument(5, 'url');
            return Eden_Oauth2_Client::i($client, $secret, $redirect, $requestUrl, $accessUrl);
        }

        public function desktop($client, $secret, $redirect, $requestUrl, $accessUrl)
        {
            Eden_Oauth2_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'url')->argument(4, 'url')->argument(5, 'url');
            return Eden_Oauth2_Desktop::i($client, $secret, $redirect, $requestUrl, $accessUrl);
        }
    }
}
/* Eden_Sql_Error */
if (!class_exists('Eden_Sql_Error')) {
    class Eden_Sql_Error extends Eden_Error
    {
        const QUERY_ERROR = '%s Query: %s';
        const TABLE_NOT_SET = 'No default table set or was passed.';
        const DATABASE_NOT_SET = 'No default database set or was passed.';
        const NOT_SUB_MODEL = 'Class %s is not a child of Eden_Model';
        const NOT_SUB_COLLECTION = 'Class %s is not a child of Eden_Collection';

        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Mysql_Error */
if (!class_exists('Eden_Mysql_Error')) {
    class Eden_Mysql_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Sql_Database */
if (!class_exists('Eden_Sql_Database')) {
    abstract class Eden_Sql_Database extends Eden_Event
    {
        const QUERY = 'Eden_Sql_Query';
        const FIRST = 'first';
        const LAST = 'last';
        const MODEL = 'Eden_Sql_Model';
        const COLLECTION = 'Eden_Sql_Collection';
        protected $_queries = array();
        protected $_connection = NULL;
        protected $_binds = array();
        protected $_model = self::MODEL;
        protected $_collection = self::COLLECTION;

        abstract public function connect(array $options = array());

        public function bind($value)
        {
            Eden_Sql_Error::i()->argument(1, 'array', 'string', 'numeric', 'null');
            if (is_array($value)) {
                foreach ($value as $i => $item) {
                    $value[$i] = $this->bind($item);
                }
                return '(' . implode(",", $value) . ')';
            } else if (is_numeric($value)) {
                return $value;
            }
            $name = ':bind' . count($this->_binds) . 'bind';
            $this->_binds[$name] = $value;
            return $name;
        }

        public function collection(array $data = array())
        {
            $collection = $this->_collection;
            return $this->$collection()->setDatabase($this)->setModel($this->_model)->set($data);
        }

        public function delete($table = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'null');
            return Eden_Sql_Delete::i($table);
        }

        public function deleteRows($table, $filters = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $query = $this->delete($table);
            if (is_array($filters)) {
                foreach ($filters as $i => $filter) {
                    $format = array_shift($filter);
                    foreach ($filter as $j => $value) {
                        $filter[$j] = $this->bind($value);
                    }
                    $filters[$i] = vsprintf($format, $filter);
                }
            }
            $query->where($filters);
            $this->query($query, $this->getBinds());
            $this->trigger($table, $filters);
            return $this;
        }

        public function getBinds()
        {
            return $this->_binds;
        }

        public function getCollection($table, array $joins = array(), $filters = NULL, array $sort = array(), $start = 0, $range = 0, $index = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'string', 'array', 'null')->argument(5, 'numeric')->argument(6, 'numeric')->argument(7, 'numeric', 'null');
            $results = $this->getRows($table, $joins, $filters, $sort, $start, $range, $index);
            $collection = $this->collection()->setTable($table)->setModel($this->_model);
            if (is_null($results)) {
                return $collection;
            }
            if (!is_null($index)) {
                return $this->model($results)->setTable($table);
            }
            return $collection->set($results);
        }

        public function getConnection()
        {
            if (!$this->_connection) {
                $this->connect();
            }
            return $this->_connection;
        }

        public function getLastInsertedId()
        {
            return $this->getConnection()->lastInsertId();
        }

        public function getModel($table, $name, $value)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string', 'numeric');
            $result = $this->getRow($table, $name, $value);
            $model = $this->model()->setTable($table);
            if (is_null($result)) {
                return $model;
            }
            return $model->set($result);
        }

        public function getQueries($index = NULL)
        {
            if (is_null($index)) {
                return $this->_queries;
            }
            if ($index == self::FIRST) {
                $index = 0;
            }
            if ($index == self::LAST) {
                $index = count($this->_queries) - 1;
            }
            if (isset($this->_queries[$index])) {
                return $this->_queries[$index];
            }
            return NULL;
        }

        public function getRow($table, $name, $value)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string', 'numeric');
            $query = $this->select()->from($table)->where($name . '=' . $this->bind($value))->limit(0, 1);
            $results = $this->query($query, $this->getBinds());
            $this->trigger($table, $name, $value, $results);
            return isset($results[0]) ? $results[0] : NULL;
        }

        public function getRows($table, array $joins = array(), $filters = NULL, array $sort = array(), $start = 0, $range = 0, $index = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'string', 'array', 'null')->argument(5, 'numeric')->argument(6, 'numeric')->argument(7, 'numeric', 'null');
            $query = $this->select()->from($table);
            foreach ($joins as $join) {
                if (!is_array($join) || count($join) < 3) {
                    continue;
                }
                if (count($join) == 3) {
                    $join[] = true;
                }
                $query->join($join[0], $join[1], $join[2], $join[3]);
            }
            if (is_array($filters)) {
                foreach ($filters as $i => $filter) {
                    $format = array_shift($filter);
                    foreach ($filter as $j => $value) {
                        $filter[$j] = $this->bind($value);
                    }
                    $filters[$i] = vsprintf($format, $filter);
                }
            }
            if (!is_null($filters)) {
                $query->where($filters);
            }
            if (!empty($sort)) {
                foreach ($sort as $key => $value) {
                    if (is_string($key) && trim($key)) {
                        $query->sortBy($key, $value);
                    }
                }
            }
            if ($range) {
                $query->limit($start, $range);
            }
            $results = $this->query($query, $this->getBinds());
            if (!is_null($index)) {
                if (empty($results)) {
                    $results = NULL;
                } else {
                    if ($index == self::FIRST) {
                        $index = 0;
                    }
                    if ($index == self::LAST) {
                        $index = count($results) - 1;
                    }
                    if (isset($results[$index])) {
                        $results = $results[$index];
                    } else {
                        $results = NULL;
                    }
                }
            }
            $this->trigger($table, $joins, $filters, $sort, $start, $range, $index, $results);
            return $results;
        }

        public function getRowsCount($table, array $joins = array(), $filters = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'string', 'array', 'null');
            $query = $this->select('COUNT(*) as count')->from($table);
            foreach ($joins as $join) {
                if (!is_array($join) || count($join) < 3) {
                    continue;
                }
                if (count($join) == 3) {
                    $join[] = true;
                }
                $query->join($join[0], $join[1], $join[2], $join[3]);
            }
            if (is_array($filters)) {
                foreach ($filters as $i => $filter) {
                    $format = array_shift($filter);
                    $filter = $this->bind($filter);
                    $filters[$i] = vsprintf($format, $filter);
                }
            }
            $query->where($filters);
            $results = $this->query($query, $this->getBinds());
            if (isset($results[0]['count'])) {
                $this->trigger($table, $joins, $filters, $results[0]['count']);
                return $results[0]['count'];
            }
            $this->trigger($table, $joins, $filters, false);
            return false;
        }

        public function insert($table = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'null');
            return Eden_Sql_Insert::i($table);
        }

        public function insertRow($table, array $setting, $bind = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'array', 'bool');
            $query = $this->insert($table);
            foreach ($setting as $key => $value) {
                if (is_null($value) || is_bool($value)) {
                    $query->set($key, $value);
                    continue;
                }
                if ((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
                    $value = $this->bind($value);
                }
                $query->set($key, $value);
            }
            $this->query($query, $this->getBinds());
            $this->trigger($table, $setting);
            return $this;
        }

        public function insertRows($table, array $settings, $bind = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(3, 'array', 'bool');
            $query = $this->insert($table);
            foreach ($settings as $index => $setting) {
                foreach ($setting as $key => $value) {
                    if (is_null($value) || is_bool($value)) {
                        $query->set($key, $value, $index);
                        continue;
                    }
                    if ((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
                        $value = $this->bind($value);
                    }
                    $query->set($key, $value, $index);
                }
            }
            $this->query($query, $this->getBinds());
            $this->trigger($table, $settings);
            return $this;
        }

        public function model(array $data = array())
        {
            $model = $this->_model;
            return $this->$model($data)->setDatabase($this);
        }

        public function query($query, array $binds = array())
        {
            Eden_Sql_Error::i()->argument(1, 'string', self::QUERY);
            $connection = $this->getConnection();
            $query = (string)$query;
            $stmt = $connection->prepare($query);
            foreach ($binds as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            if (!$stmt->execute()) {
                $error = $stmt->errorInfo();
                foreach ($binds as $key => $value) {
                    $query = str_replace($key, "'$value'", $query);
                }
                Eden_Sql_Error::i()->setMessage(Eden_Sql_Error::QUERY_ERROR)->addVariable($query)->addVariable($error[2])->trigger();
            }
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->_queries[] = array('query' => $query, 'binds' => $binds, 'results' => $results);
            $this->_binds = array();
            $this->trigger($query, $binds, $results);
            return $results;
        }

        public function search($table = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'null');
            $search = Eden_Sql_Search::i($this)->setCollection($this->_collection)->setModel($this->_model);
            if ($table) {
                $search->setTable($table);
            }
            return $search;
        }

        public function select($select = '*')
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'array');
            return Eden_Sql_Select::i($select);
        }

        public function setBinds(array $binds)
        {
            $this->_binds = $binds;
            return $this;
        }

        public function setCollection($collection)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string');
            if (!is_subclass_of($collection, self::COLLECTION)) {
                $error->setMessage(Eden_Sql_Error::NOT_SUB_COLLECTION)->addVariable($collection)->trigger();
            }
            $this->_collection = $collection;
            return $this;
        }

        public function setModel($model)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string');
            if (!is_subclass_of($model, self::MODEL)) {
                $error->setMessage(Eden_Sql_Error::NOT_SUB_MODEL)->addVariable($model)->trigger();
            }
            $this->_model = $model;
            return $this;
        }

        public function setRow($table, $name, $value, array $setting)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string', 'numeric');
            $row = $this->getRow($table, $name, $value);
            if (!$row) {
                $setting[$name] = $value;
                return $this->insertRow($table, $setting);
            } else {
                return $this->updateRows($table, $setting, array(array($name . '=%s', $value)));
            }
        }

        public function update($table = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'null');
            return Eden_Sql_Update::i($table);
        }

        public function updateRows($table, array $setting, $filters = NULL, $bind = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(4, 'array', 'bool');
            $query = $this->update($table);
            foreach ($setting as $key => $value) {
                if (is_null($value) || is_bool($value)) {
                    $query->set($key, $value);
                    continue;
                }
                if ((is_bool($bind) && $bind) || (is_array($bind) && in_array($key, $bind))) {
                    $value = $this->bind($value);
                }
                $query->set($key, $value);
            }
            if (is_array($filters)) {
                foreach ($filters as $i => $filter) {
                    $format = array_shift($filter);
                    foreach ($filter as $j => $value) {
                        $filter[$j] = $this->bind($value);
                    }
                    $filters[$i] = vsprintf($format, $filter);
                }
            }
            $query->where($filters);
            $this->query($query, $this->getBinds());
            $this->trigger($table, $setting, $filters);
            return $this;
        }
    }
}
/* Eden_Sql_Query */
if (!class_exists('Eden_Sql_Query')) {
    abstract class Eden_Sql_Query extends Eden_Class
    {
        public function __toString()
        {
            return $this->getQuery();
        }

        abstract public function getQuery();
    }
}
/* Eden_Sql_Delete */
if (!class_exists('Eden_Sql_Delete')) {
    class Eden_Sql_Delete extends Eden_Sql_Query
    {
        protected $_table = NULL;
        protected $_where = array();

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($table = NULL)
        {
            if (is_string($table)) {
                $this->setTable($table);
            }
        }

        public function getQuery()
        {
            return 'DELETE FROM ' . $this->_table . ' WHERE ' . implode(' AND ', $this->_where) . ';';
        }

        public function setTable($table)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_table = $table;
            return $this;
        }

        public function where($where)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'array');
            if (is_string($where)) {
                $where = array($where);
            }
            $this->_where = array_merge($this->_where, $where);
            return $this;
        }
    }
}
/* Eden_Sql_Select */
if (!class_exists('Eden_Sql_Select')) {
    class Eden_Sql_Select extends Eden_Sql_Query
    {
        protected $_select = NULL;
        protected $_from = NULL;
        protected $_joins = NULL;
        protected $_where = array();
        protected $_sortBy = array();
        protected $_group = array();
        protected $_page = NULL;
        protected $_length = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($select = '*')
        {
            $this->select($select);
        }

        public function from($from)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_from = $from;
            return $this;
        }

        public function getQuery()
        {
            $joins = empty($this->_joins) ? '' : implode(' ', $this->_joins);
            $where = empty($this->_where) ? '' : 'WHERE ' . implode(' AND ', $this->_where);
            $sort = empty($this->_sortBy) ? '' : 'ORDER BY ' . implode(',', $this->_sortBy);
            $limit = is_null($this->_page) ? '' : 'LIMIT ' . $this->_page . ',' . $this->_length;
            $group = empty($this->_group) ? '' : 'GROUP BY ' . implode(',', $this->_group);
            $query = sprintf('SELECT %s FROM %s %s %s %s %s %s;', $this->_select, $this->_from, $joins, $where, $group, $sort, $limit);
            return str_replace(' ', ' ', $query);
        }

        public function groupBy($group)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'array');
            if (is_string($group)) {
                $group = array($group);
            }
            $this->_group = $group;
            return $this;
        }

        public function innerJoin($table, $where, $using = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'bool');
            return $this->join('INNER', $table, $where, $using);
        }

        public function join($type, $table, $where, $using = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'bool');
            $linkage = $using ? 'USING (' . $where . ')' : ' ON (' . $where . ')';
            $this->_joins[] = $type . ' JOIN ' . $table . ' ' . $linkage;
            return $this;
        }

        public function leftJoin($table, $where, $using = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'bool');
            return $this->join('LEFT', $table, $where, $using);
        }

        public function limit($page, $length)
        {
            Eden_Sql_Error::i()->argument(1, 'numeric')->argument(2, 'numeric');
            $this->_page = $page;
            $this->_length = $length;
            return $this;
        }

        public function outerJoin($table, $where, $using = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'bool');
            return $this->join('OUTER', $table, $where, $using);
        }

        public function rightJoin($table, $where, $using = true)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'bool');
            return $this->join('RIGHT', $table, $where, $using);
        }

        public function select($select = '*')
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'array');
            if (is_array($select)) {
                $select = implode(',', $select);
            }
            $this->_select = $select;
            return $this;
        }

        public function sortBy($field, $order = 'ASC')
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $this->_sortBy[] = $field . ' ' . $order;
            return $this;
        }

        public function where($where)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'array');
            if (is_string($where)) {
                $where = array($where);
            }
            $this->_where = array_merge($this->_where, $where);
            return $this;
        }
    }
}
/* Eden_Sql_Update */
if (!class_exists('Eden_Sql_Update')) {
    class Eden_Sql_Update extends Eden_Sql_Delete
    {
        protected $_set = array();

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function getQuery()
        {
            $set = array();
            foreach ($this->_set as $key => $value) {
                $set[] = "{$key}={$value}";
            }
            return 'UPDATE ' . $this->_table . ' SET ' . implode(',', $set) . ' WHERE ' . implode(' AND ', $this->_where) . ';';
        }

        public function set($key, $value)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'scalar', 'null');
            if (is_null($value)) {
                $value = 'NULL';
            } else if (is_bool($value)) {
                $value = $value ? 1 : 0;
            }
            $this->_set[$key] = $value;
            return $this;
        }
    }
}
/* Eden_Sql_Insert */
if (!class_exists('Eden_Sql_Insert')) {
    class Eden_Sql_Insert extends Eden_Sql_Query
    {
        protected $_setKey = array();
        protected $_setVal = array();

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($table = NULL)
        {
            if (is_string($table)) {
                $this->setTable($table);
            }
        }

        public function getQuery()
        {
            $multiValList = array();
            foreach ($this->_setVal as $val) {
                $multiValList[] = '(' . implode(',', $val) . ')';
            }
            return 'INSERT INTO ' . $this->_table . ' (' . implode(',', $this->_setKey) . ") VALUES " . implode(",\n", $multiValList) . ';';
        }

        public function set($key, $value, $index = 0)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'scalar', 'null');
            if (!in_array($key, $this->_setKey)) {
                $this->_setKey[] = $key;
            }
            if (is_null($value)) {
                $value = 'NULL';
            } else if (is_bool($value)) {
                $value = $value ? 1 : 0;
            }
            $this->_setVal[$index][] = $value;
            return $this;
        }

        public function setTable($table)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_table = $table;
            return $this;
        }
    }
}
/* Eden_Sql_Collection */
if (!class_exists('Eden_Sql_Collection')) {
    class Eden_Sql_Collection extends Eden_Collection
    {
        protected $_model = Eden_Sql_Database::MODEL;
        protected $_database = NULL;
        protected $_table = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function add($row = array())
        {
            Eden_Sql_Error::i()->argument(1, 'array', $this->_model);
            if (is_array($row)) {
                $model = $this->_model;
                $row = $this->$model($row);
            }
            if (!is_null($this->_database)) {
                $row->setDatabase($this->_database);
            }
            if (!is_null($this->_table)) {
                $row->setTable($this->_table);
            }
            $this->_list[] = $row;
            return $this;
        }

        public function setDatabase(Eden_Sql_Database $database)
        {
            $this->_database = $database;
            foreach ($this->_list as $row) {
                if (!is_object($row) || !method_exists($row, __FUNCTION__)) {
                    continue;
                }
                $row->setDatabase($database);
            }
            return $this;
        }

        public function setModel($model)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string');
            if (!is_subclass_of($model, 'Eden_Model')) {
                $error->setMessage(Eden_Sql_Error::NOT_SUB_MODEL)->addVariable($model)->trigger();
            }
            $this->_model = $model;
            return $this;
        }

        public function setTable($table)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_table = $table;
            foreach ($this->_list as $row) {
                if (!is_object($row) || !method_exists($row, __FUNCTION__)) {
                    continue;
                }
                $row->setTable($table);
            }
            return $this;
        }
    }
}
/* Eden_Sql_Model */
if (!class_exists('Eden_Sql_Model')) {
    class Eden_Sql_Model extends Eden_Model
    {
        const COLUMNS = 'columns';
        const PRIMARY = 'primary';
        const DATETIME = 'Y-m-d h:i:s';
        const DATE = 'Y-m-d';
        const TIME = 'h:i:s';
        const TIMESTAMP = 'U';
        protected $_table = NULL;
        protected $_database = NULL;
        protected static $_meta = array();

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function formatTime($column, $format = self::DATETIME)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            if (!isset($this->_data[$column])) {
                return $this;
            }
            if (is_numeric($this->_data[$column])) {
                $this->_data[$column] = (int)$this->_data[$column];
            }
            if (is_string($this->_data[$column])) {
                $this->_data[$column] = strtotime($this->_data[$column]);
            }
            if (!is_int($this->_data[$column])) {
                return $this;
            }
            $this->_data[$column] = date($format, $this->_data[$column]);
            return $this;
        }

        public function insert($table = NULL, Eden_Sql_Database $database = NULL)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string', 'null');
            if (is_null($table)) {
                if (!$this->_table) {
                    $error->setMessage(Eden_Sql_Error::TABLE_NOT_SET)->trigger();
                }
                $table = $this->_table;
            }
            if (is_null($database)) {
                if (!$this->_database) {
                    $error->setMessage(Eden_Sql_Error::DATABASE_NOT_SET)->trigger();
                }
                $database = $this->_database;
            }
            $meta = $this->_getMeta($table, $database);
            $data = $this->_getValidColumns(array_keys($meta[self::COLUMNS]));
            $this->_original = $this->_data;
            $database->insertRow($table, $data);
            if (count($meta[self::PRIMARY]) == 1) {
                $this->_data[$meta[self::PRIMARY][0]] = $database->getLastInsertedId();
            }
            return $this;
        }

        public function remove($table = NULL, Eden_Sql_Database $database = NULL, $primary = NULL)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string', 'null');
            if (is_null($table)) {
                if (!$this->_table) {
                    $error->setMessage(Eden_Sql_Error::TABLE_NOT_SET)->trigger();
                }
                $table = $this->_table;
            }
            if (is_null($database)) {
                if (!$this->_database) {
                    $error->setMessage(Eden_Sql_Error::DATABASE_NOT_SET)->trigger();
                }
                $database = $this->_database;
            }
            $meta = $this->_getMeta($table, $database);
            $data = $this->_getValidColumns(array_keys($meta[self::COLUMNS]));
            if (is_null($primary)) {
                $primary = $meta[self::PRIMARY];
            }
            if (is_string($primary)) {
                $primary = array($primary);
            }
            $filter = array();
            foreach ($primary as $column) {
                if (!isset($data[$column])) {
                    return $this;
                }
                $filter[] = array($column . '=%s', $data[$column]);
            }
            $database->deleteRows($table, $filter);
            return $this;
        }

        public function save($table = NULL, Eden_Sql_Database $database = NULL, $primary = NULL)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string', 'null');
            if (is_null($table)) {
                if (!$this->_table) {
                    $error->setMessage(Eden_Sql_Error::TABLE_NOT_SET)->trigger();
                }
                $table = $this->_table;
            }
            if (is_null($database)) {
                if (!$this->_database) {
                    $error->setMessage(Eden_Sql_Error::DATABASE_NOT_SET)->trigger();
                }
                $database = $this->_database;
            }
            $meta = $this->_getMeta($table, $database);
            if (is_null($primary)) {
                $primary = $meta[self::PRIMARY];
            }
            if (is_string($primary)) {
                $primary = array($primary);
            }
            $primarySet = $this->_isPrimarySet($primary);
            $this->_original = $this->_data;
            if (empty($primary) || !$primarySet) {
                return $this->insert($table, $database);
            }
            return $this->update($table, $database, $primary);
        }

        public function setDatabase(Eden_Sql_Database $database)
        {
            $this->_database = $database;
            return $this;
        }

        public function setTable($table)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_table = $table;
            return $this;
        }

        public function update($table = NULL, Eden_Sql_Database $database = NULL, $primary = NULL)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string', 'null');
            if (is_null($table)) {
                if (!$this->_table) {
                    $error->setMessage(Eden_Sql_Error::TABLE_NOT_SET)->trigger();
                }
                $table = $this->_table;
            }
            if (is_null($database)) {
                if (!$this->_database) {
                    $error->setMessage(Eden_Sql_Error::DATABASE_NOT_SET)->trigger();
                }
                $database = $this->_database;
            }
            $meta = $this->_getMeta($table, $database);
            $data = $this->_getValidColumns(array_keys($meta[self::COLUMNS]));
            $this->_original = $this->_data;
            if (is_null($primary)) {
                $primary = $meta[self::PRIMARY];
            }
            if (is_string($primary)) {
                $primary = array($primary);
            }
            $filter = array();
            foreach ($primary as $column) {
                $filter[] = array($column . '=%s', $data[$column]);
            }
            $database->updateRows($table, $data, $filter);
            return $this;
        }

        protected function _isLoaded($table = NULL, $database = NULL)
        {
            if (is_null($table)) {
                if (!$this->_table) {
                    return false;
                }
                $table = $this->_table;
            }
            if (is_null($database)) {
                if (!$this->_database) {
                    return false;
                }
                $database = $this->_database;
            }
            $meta = $this->_getMeta($table, $database);
            return $this->_isPrimarySet($meta[self::PRIMARY]);
        }

        protected function _isPrimarySet(array $primary)
        {
            foreach ($primary as $column) {
                if (is_null($this[$column])) {
                    return false;
                }
            }
            return true;
        }

        protected function _getMeta($table, $database)
        {
            $uid = spl_object_hash($database);
            if (isset(self::$_meta[$uid][$table])) {
                return self::$_meta[$uid][$table];
            }
            $columns = $database->getColumns($table);
            $meta = array();
            foreach ($columns as $i => $column) {
                $meta[self::COLUMNS][$column['Field']] = array('type' => $column['Type'], 'key' => $column['Key'], 'default' => $column['Default'], 'empty' => $column['Null'] == 'YES');
                if ($column['Key'] == 'PRI') {
                    $meta[self::PRIMARY][] = $column['Field'];
                }
            }
            self::$_meta[$uid][$table] = $meta;
            return $meta;
        }

        protected function _getValidColumns($columns)
        {
            $valid = array();
            foreach ($columns as $column) {
                if (!isset($this->_data[$column])) {
                    continue;
                }
                $valid[$column] = $this->_data[$column];
            }
            return $valid;
        }
    }
}
/* Eden_Sql_Search */
if (!class_exists('Eden_Sql_Search')) {
    class Eden_Sql_Search extends Eden_Class
    {
        const LEFT = 'LEFT';
        const RIGHT = 'RIGHT';
        const INNER = 'INNER';
        const OUTER = 'OUTER';
        const ASC = 'ASC';
        const DESC = 'DESC';
        protected $_database = NULL;
        protected $_table = NULL;
        protected $_columns = array();
        protected $_join = array();
        protected $_filter = array();
        protected $_sort = array();
        protected $_group = array();
        protected $_start = 0;
        protected $_range = 0;
        protected $_model = Eden_Sql_Database::MODEL;
        protected $_collection = Eden_Sql_Database::COLLECTION;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __call($name, $args)
        {
            if (strpos($name, 'filterBy') === 0) {
                $separator = '_';
                if (isset($args[1]) && is_scalar($args[1])) {
                    $separator = (string)$args[1];
                }
                $key = Eden_Type_String::i($name)->substr(8)->preg_replace("/([A-Z0-9])/", $separator . "$1")->substr(strlen($separator))->strtolower()->get();
                if (!isset($args[0])) {
                    $args[0] = NULL;
                }
                $key = $key . '=%s';
                $this->addFilter($key, $args[0]);
                return $this;
            }
            if (strpos($name, 'sortBy') === 0) {
                $separator = '_';
                if (isset($args[1]) && is_scalar($args[1])) {
                    $separator = (string)$args[1];
                }
                $key = Eden_Type_String::i($name)->substr(6)->preg_replace("/([A-Z0-9])/", $separator . "$1")->substr(strlen($separator))->strtolower()->get();
                if (!isset($args[0])) {
                    $args[0] = self::ASC;
                }
                $this->addSort($key, $args[0]);
                return $this;
            }
            try {
                return parent::__call($name, $args);
            } catch (Eden_Error $e) {
                Eden_Sql_Error::i($e->getMessage())->trigger();
            }
        }

        public function __construct(Eden_Sql_Database $database)
        {
            $this->_database = $database;
        }

        public function addFilter()
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_filter[] = func_get_args();
            return $this;
        }

        public function addInnerJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::INNER, $table, $where, false);
            return $this;
        }

        public function addInnerJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::INNER, $table, $where, true);
            return $this;
        }

        public function addLeftJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::LEFT, $table, $where, false);
            return $this;
        }

        public function addLeftJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::LEFT, $table, $where, true);
            return $this;
        }

        public function addOuterJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::OUTER, $table, $where, false);
            return $this;
        }

        public function addOuterJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::OUTER, $table, $where, true);
            return $this;
        }

        public function addRightJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::RIGHT, $table, $where, false);
            return $this;
        }

        public function addRightJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::RIGHT, $table, $where, true);
            return $this;
        }

        public function addSort($column, $order = self::ASC)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            if ($order != self::DESC) {
                $order = self::ASC;
            }
            $this->_sort[$column] = $order;
            return $this;
        }

        public function getCollection()
        {
            $collection = $this->_collection;
            return $this->$collection()->setDatabase($this->_database)->setTable($this->_table)->setModel($this->_model)->set($this->getRows());
        }

        public function getModel($index = 0)
        {
            Eden_Sql_Error::i()->argument(1, 'int');
            return $this->getCollection()->offsetGet($index);
        }

        public function getRow($index = 0, $column = NULL)
        {
            Eden_Sql_Error::i()->argument(1, 'int', 'string')->argument(2, 'string', 'null');
            if (is_string($index)) {
                $column = $index;
                $index = 0;
            }
            $rows = $this->getRows();
            if (!is_null($column) && isset($rows[$index][$column])) {
                return $rows[$index][$column];
            } else if (is_null($column) && isset($rows[$index])) {
                return $rows[$index];
            }
            return NULL;
        }

        public function getRows()
        {
            $query = $this->_getQuery();
            if (!empty($this->_columns)) {
                $query->select(implode(',', $this->_columns));
            }
            foreach ($this->_sort as $key => $value) {
                $query->sortBy($key, $value);
            }
            if ($this->_range) {
                $query->limit($this->_start, $this->_range);
            }
            if (!empty($this->_group)) {
                $query->groupBy($this->_group);
            }
            return $this->_database->query($query, $this->_database->getBinds());
        }

        public function getTotal()
        {
            $query = $this->_getQuery()->select('COUNT(*) as total');
            $rows = $this->_database->query($query, $this->_database->getBinds());
            if (!isset($rows[0]['total'])) {
                return 0;
            }
            return $rows[0]['total'];
        }

        public function innerJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::INNER, $table, $where, false);
            return $this;
        }

        public function innerJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::INNER, $table, $where, true);
            return $this;
        }

        public function leftJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::LEFT, $table, $where, false);
            return $this;
        }

        public function leftJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::LEFT, $table, $where, true);
            return $this;
        }

        public function outerJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::OUTER, $table, $where, false);
            return $this;
        }

        public function outerJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::OUTER, $table, $where, true);
            return $this;
        }

        public function rightJoinOn($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::RIGHT, $table, $where, false);
            return $this;
        }

        public function rightJoinUsing($table, $where)
        {
            Eden_Sql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $where = func_get_args();
            $table = array_shift($where);
            $this->_join[] = array(self::RIGHT, $table, $where, true);
            return $this;
        }

        public function setColumns($columns)
        {
            if (!is_array($columns)) {
                $columns = func_get_args();
            }
            $this->_columns = $columns;
            return $this;
        }

        public function setCollection($collection)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string');
            if (!is_subclass_of($collection, 'Eden_Collection')) {
                $error->setMessage(Eden_Sql_Error::NOT_SUB_COLLECTION)->addVariable($collection)->trigger();
            }
            $this->_collection = $collection;
            return $this;
        }

        public function setGroup($group)
        {
            Eden_Sql_Error::i()->argument(1, 'string', 'array');
            if (is_string($group)) {
                $group = array($group);
            }
            $this->_group = $group;
            return $this;
        }

        public function setModel($model)
        {
            $error = Eden_Sql_Error::i()->argument(1, 'string');
            if (!is_subclass_of($model, 'Eden_Model')) {
                $error->setMessage(Eden_Sql_Error::NOT_SUB_MODEL)->addVariable($model)->trigger();
            }
            $this->_model = $model;
            return $this;
        }

        public function setPage($page)
        {
            Eden_Sql_Error::i()->argument(1, 'int');
            if ($page < 1) {
                $page = 1;
            }
            $this->_start = ($page - 1) * $this->_range;
            return $this;
        }

        public function setRange($range)
        {
            Eden_Sql_Error::i()->argument(1, 'int');
            if ($range < 0) {
                $range = 25;
            }
            $this->_range = $range;
            return $this;
        }

        public function setStart($start)
        {
            Eden_Sql_Error::i()->argument(1, 'int');
            if ($start < 0) {
                $start = 0;
            }
            $this->_start = $start;
            return $this;
        }

        public function setTable($table)
        {
            Eden_Sql_Error::i()->argument(1, 'string');
            $this->_table = $table;
            return $this;
        }

        protected function _getQuery()
        {
            $query = $this->_database->select()->from($this->_table);
            foreach ($this->_join as $join) {
                if (!is_array($join[2])) {
                    $join[2] = array($join[2]);
                }
                $where = array_shift($join[2]);
                if (!empty($join[2])) {
                    foreach ($join[2] as $i => $value) {
                        $join[2][$i] = $this->_database->bind($value);
                    }
                    $where = vsprintf($where, $join[2]);
                }
                $query->join($join[0], $join[1], $where, $join[3]);
            }
            foreach ($this->_filter as $i => $filter) {
                $where = array_shift($filter);
                if (!empty($filter)) {
                    foreach ($filter as $i => $value) {
                        $filter[$i] = $this->_database->bind($value);
                    }
                    $where = vsprintf($where, $filter);
                }
                $query->where($where);
            }
            return $query;
        }
    }
}
/* Eden_Mysql_Alter */
if (!class_exists('Eden_Mysql_Alter')) {
    class Eden_Mysql_Alter extends Eden_Sql_Query
    {
        protected $_name = NULL;
        protected $_changeFields = array();
        protected $_addFields = array();
        protected $_removeFields = array();
        protected $_addKeys = array();
        protected $_removeKeys = array();
        protected $_addUniqueKeys = array();
        protected $_removeUniqueKeys = array();
        protected $_addPrimaryKeys = array();
        protected $_removePrimaryKeys = array();

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($name = NULL)
        {
            if (is_string($name)) {
                $this->setName($name);
            }
        }

        public function addField($name, array $attributes)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_addFields[$name] = $attributes;
            return $this;
        }

        public function addKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_addKeys[] = '`' . $name . '`';
            return $this;
        }

        public function addPrimaryKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_addPrimaryKeys[] = '`' . $name . '`';
            return $this;
        }

        public function addUniqueKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_addUniqueKeys[] = '`' . $name . '`';
            return $this;
        }

        public function changeField($name, array $attributes)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_changeFields[$name] = $attributes;
            return $this;
        }

        public function getQuery($unbind = false)
        {
            $fields = array();
            $table = '`' . $this->_name . '`';
            foreach ($this->_removeFields as $name) {
                $fields[] = 'DROP `' . $name . '`';
            }
            foreach ($this->_addFields as $name => $attr) {
                $field = array('ADD `' . $name . '`');
                if (isset($attr['type'])) {
                    $field[] = isset($attr['length']) ? $attr['type'] . '(' . $attr['length'] . ')' : $attr['type'];
                }
                if (isset($attr['attribute'])) {
                    $field[] = $attr['attribute'];
                }
                if (isset($attr['null'])) {
                    if ($attr['null'] == false) {
                        $field[] = 'NOT NULL';
                    } else {
                        $field[] = 'DEFAULT NULL';
                    }
                }
                if (isset($attr['default']) && $attr['default'] !== false) {
                    if (!isset($attr['null']) || $attr['null'] == false) {
                        if (is_string($attr['default'])) {
                            $field[] = 'DEFAULT \'' . $attr['default'] . '\'';
                        } else if (is_numeric($attr['default'])) {
                            $field[] = 'DEFAULT ' . $attr['default'];
                        }
                    }
                }
                if (isset($attr['auto_increment']) && $attr['auto_increment'] == true) {
                    $field[] = 'auto_increment';
                }
                $fields[] = implode(' ', $field);
            }
            foreach ($this->_changeFields as $name => $attr) {
                $field = array('CHANGE `' . $name . '` `' . $name . '`');
                if (isset($attr['name'])) {
                    $field = array('CHANGE `' . $name . '` `' . $attr['name'] . '`');
                }
                if (isset($attr['type'])) {
                    $field[] = isset($attr['length']) ? $attr['type'] . '(' . $attr['length'] . ')' : $attr['type'];
                }
                if (isset($attr['attribute'])) {
                    $field[] = $attr['attribute'];
                }
                if (isset($attr['null'])) {
                    if ($attr['null'] == false) {
                        $field[] = 'NOT NULL';
                    } else {
                        $field[] = 'DEFAULT NULL';
                    }
                }
                if (isset($attr['default']) && $attr['default'] !== false) {
                    if (!isset($attr['null']) || $attr['null'] == false) {
                        if (is_string($attr['default'])) {
                            $field[] = 'DEFAULT \'' . $attr['default'] . '\'';
                        } else if (is_numeric($attr['default'])) {
                            $field[] = 'DEFAULT ' . $attr['default'];
                        }
                    }
                }
                if (isset($attr['auto_increment']) && $attr['auto_increment'] == true) {
                    $field[] = 'auto_increment';
                }
                $fields[] = implode(' ', $field);
            }
            foreach ($this->_removeKeys as $key) {
                $fields[] = 'DROP INDEX `' . $key . '`';
            }
            if (!empty($this->_addKeys)) {
                $fields[] = 'ADD INDEX (' . implode(',', $this->_addKeys) . ')';
            }
            foreach ($this->_removeUniqueKeys as $key) {
                $fields[] = 'DROP INDEX `' . $key . '`';
            }
            if (!empty($this->_addUniqueKeys)) {
                $fields[] = 'ADD UNIQUE (' . implode(',', $this->_addUniqueKeys) . ')';
            }
            foreach ($this->_removePrimaryKeys as $key) {
                $fields[] = 'DROP PRIMARY KEY `' . $key . '`';
            }
            if (!empty($this->_addPrimaryKeys)) {
                $fields[] = 'ADD PRIMARY KEY (' . implode(',', $this->_addPrimaryKeys) . ')';
            }
            $fields = implode(",\n", $fields);
            return sprintf('ALTER TABLE %s %s;', $table, $fields);
        }

        public function removeField($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_removeFields[] = $name;
            return $this;
        }

        public function removeKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_removeKeys[] = $name;
            return $this;
        }

        public function removePrimaryKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_removePrimaryKeys[] = $name;
            return $this;
        }

        public function removeUniqueKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_removeUniqueKeys[] = $name;
            return $this;
        }

        public function setName($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_name = $name;
            return $this;
        }
    }
}
/* Eden_Mysql_Create */
if (!class_exists('Eden_Mysql_Create')) {
    class Eden_Mysql_Create extends Eden_Sql_Query
    {
        protected $_name = NULL;
        protected $_comments = NULL;
        protected $_fields = array();
        protected $_keys = array();
        protected $_uniqueKeys = array();
        protected $_primaryKeys = array();

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($name = NULL)
        {
            if (is_string($name)) {
                $this->setName($name);
            }
        }

        public function addField($name, array $attributes)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_fields[$name] = $attributes;
            return $this;
        }

        public function addKey($name, array $fields)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_keys[$name] = $fields;
            return $this;
        }

        public function addPrimaryKey($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_primaryKeys[] = $name;
            return $this;
        }

        public function addUniqueKey($name, array $fields)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_uniqueKeys[$name] = $fields;
            return $this;
        }

        public function getQuery($unbind = false)
        {
            $table = '`' . $this->_name . '`';
            $fields = array();
            foreach ($this->_fields as $name => $attr) {
                $field = array('`' . $name . '`');
                if (isset($attr['type'])) {
                    $field[] = isset($attr['length']) ? $attr['type'] . '(' . $attr['length'] . ')' : $attr['type'];
                }
                if (isset($attr['attribute'])) {
                    $field[] = $attr['attribute'];
                }
                if (isset($attr['null'])) {
                    if ($attr['null'] == false) {
                        $field[] = 'NOT NULL';
                    } else {
                        $field[] = 'DEFAULT NULL';
                    }
                }
                if (isset($attr['default']) && $attr['default'] !== false) {
                    if (!isset($attr['null']) || $attr['null'] == false) {
                        if (is_string($attr['default'])) {
                            $field[] = 'DEFAULT \'' . $attr['default'] . '\'';
                        } else if (is_numeric($attr['default'])) {
                            $field[] = 'DEFAULT ' . $attr['default'];
                        }
                    }
                }
                if (isset($attr['auto_increment']) && $attr['auto_increment'] == true) {
                    $field[] = 'auto_increment';
                }
                $fields[] = implode(' ', $field);
            }
            $fields = !empty($fields) ? implode(',', $fields) : '';
            $primary = !empty($this->_primaryKeys) ? ',PRIMARY KEY (`' . implode('`,`', $this->_primaryKeys) . '`)' : '';
            $uniques = array();
            foreach ($this->_uniqueKeys as $key => $value) {
                $uniques[] = 'UNIQUE KEY `' . $key . '` (`' . implode('`,`', $value) . '`)';
            }
            $uniques = !empty($uniques) ? ',' . implode(",\n", $uniques) : '';
            $keys = array();
            foreach ($this->_keys as $key => $value) {
                $keys[] = 'KEY `' . $key . '` (`' . implode('`,`', $value) . '`)';
            }
            $keys = !empty($keys) ? ',' . implode(",\n", $keys) : '';
            return sprintf('CREATE TABLE %s (%s%s%s%s)', $table, $fields, $primary, $unique, $keys);
        }

        public function setComments($comments)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_comments = $comments;
            return $this;
        }

        public function setFields(array $fields)
        {
            $this->_fields = $fields;
            return $this;
        }

        public function setKeys(array $keys)
        {
            $this->_keys = $keys;
            return $this;
        }

        public function setName($name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_name = $name;
            return $this;
        }

        public function setPrimaryKeys(array $primaryKeys)
        {
            $this->_primaryKeys = $primaryKeys;
            return $this;
        }

        public function setUniqueKeys(array $uniqueKeys)
        {
            $this->_uniqueKeys = $uniqueKeys;
            return $this;
        }
    }
}
/* Eden_Mysql_Subselect */
if (!class_exists('Eden_Mysql_Subselect')) {
    class Eden_Mysql_Subselect extends Eden_Class
    {
        protected $_parentQuery;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct(Eden_Sql_Select $parentQuery, $select = '*')
        {
            Eden_Mysql_Error::i()->argument(2, 'string');
            $this->setParentQuery($parentQuery);
            $this->_select = is_array($select) ? implode(',', $select) : $select;
        }

        public function getQuery()
        {
            return '(' . substr(parent::getQuery(), 0, -1) . ')';
        }

        public function setParentQuery(Eden_Sql_Select $parentQuery)
        {
            $this->_parentQuery = $parentQuery;
            return $this;
        }
    }
}
/* Eden_Mysql_Utility */
if (!class_exists('Eden_Mysql_Utility')) {
    class Eden_Mysql_Utility extends Eden_Sql_Query
    {
        protected $_query = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function dropTable($table)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_query = 'DROP TABLE `' . $table . '`';
            return $this;
        }

        public function getQuery()
        {
            return $this->_query . ';';
        }

        public function renameTable($table, $name)
        {
            Eden_Mysql_Error::i()->argument(1, 'string')->argument(2, 'string');
            $this->_query = 'RENAME TABLE `' . $table . '` TO `' . $name . '`';
            return $this;
        }

        public function showColumns($table, $where = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string')->argument(2, 'string', 'null');
            $where = $where ? ' WHERE ' . $where : NULL;
            $this->_query = 'SHOW FULL COLUMNS FROM `' . $table . '`' . $where;
            return $this;
        }

        public function showTables($like = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string', 'null');
            $like = $like ? ' LIKE ' . $like : NULL;
            $this->_query = 'SHOW TABLES' . $like;
            return $this;
        }

        public function truncate($table)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $this->_query = 'TRUNCATE `' . $table . '`';
            return $this;
        }
    }
}
/* Eden_Mysql */
if (!class_exists('Eden_Mysql')) {
    class Eden_Mysql extends Eden_Sql_Database
    {
        protected $_host = 'localhost';
        protected $_name = NULL;
        protected $_user = NULL;
        protected $_pass = NULL;
        protected $_model = self::MODEL;
        protected $_collection = self::COLLECTION;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($host, $name, $user, $pass = NULL, $port = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string', 'null')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null')->argument(5, 'numeric', 'null');
            $this->_host = $host;
            $this->_name = $name;
            $this->_user = $user;
            $this->_pass = $pass;
            $this->_port = $port;
        }

        public function alter($name = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string', 'null');
            return Eden_Mysql_Alter::i($name);
        }

        public function create($name = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string', 'null');
            return Eden_Mysql_Create::i($name);
        }

        public function connect(array $options = array())
        {
            $host = $port = NULL;
            if (!is_null($this->_host)) {
                $host = 'host=' . $this->_host . ';';
                if (!is_null($this->_port)) {
                    $port = 'port=' . $this->_port . ';';
                }
            }
            $connection = 'mysql:' . $host . $port . 'dbname=' . $this->_name;
            $this->_connection = new PDO($connection, $this->_user, $this->_pass, $options);
            $this->trigger();
            return $this;
        }

        public function subselect($parentQuery, $select = '*')
        {
            Eden_Mysql_Error::i()->argument(2, 'string');
            return Eden_Mysql_Subselect::i($parentQuery, $select);
        }

        public function utility()
        {
            return Eden_Mysql_Utility::i();
        }

        public function getColumns($table, $filters = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $query = $this->utility();
            if (is_array($filters)) {
                foreach ($filters as $i => $filter) {
                    $format = array_shift($filter);
                    $filter = $this->bind($filter);
                    $filters[$i] = vsprintf($format, $filter);
                }
            }
            $query->showColumns($table, $filters);
            return $this->query($query, $this->getBinds());
        }

        public function getPrimaryKey($table)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $query = $this->utility();
            $results = $this->getColumns($table, "`Key`='PRI'");
            return isset($results[0]['Field']) ? $results[0]['Field'] : NULL;
        }

        public function getSchema()
        {
            $backup = array();
            $tables = $this->getTables();
            foreach ($tables as $table) {
                $backup[] = $this->getBackup();
            }
            return implode("\n\n", $backup);
        }

        public function getTables($like = NULL)
        {
            Eden_Mysql_Error::i()->argument(1, 'string', 'null');
            $query = $this->utility();
            $like = $like ? $this->bind($like) : NULL;
            $results = $this->query($query->showTables($like), $q->getBinds());
            $newResults = array();
            foreach ($results as $result) {
                foreach ($result as $key => $value) {
                    $newResults[] = $value;
                    break;
                }
            }
            return $newResults;
        }

        public function getTableSchema($table)
        {
            Eden_Mysql_Error::i()->argument(1, 'string');
            $backup = array();
            $schema = $this->getColumns($table);
            if (count($schema)) {
                $query = $this->create()->setName($table);
                foreach ($schema as $field) {
                    $fieldTypeArray = explode(' ', $field['Type']);
                    $typeArray = explode('(', $fieldTypeArray[0]);
                    $type = $typeArray[0];
                    $length = str_replace(')', '', $typeArray[1]);
                    $attribute = isset($fieldTypeArray[1]) ? $fieldTypeArray[1] : NULL;
                    $null = strtolower($field['Null']) == 'no' ? false : true;
                    $increment = strtolower($field['Extra']) == 'auto_increment' ? true : false;
                    $q->addField($field['Field'], array('type' => $type, 'length' => $length, 'attribute' => $attribute, 'null' => $null, 'default' => $field['Default'], 'auto_increment' => $increment));
                    switch ($field['Key']) {
                        case 'PRI':
                            $query->addPrimaryKey($field['Field']);
                            break;
                        case 'UNI':
                            $query->addUniqueKey($field['Field'], array($field['Field']));
                            break;
                        case 'MUL':
                            $query->addKey($field['Field'], array($field['Field']));
                            break;
                    }
                }
                $backup[] = $query;
            }
            $rows = $this->query($this->select->from($table)->getQuery());
            if (count($rows)) {
                $query = $this->insert($table);
                foreach ($rows as $index => $row) {
                    foreach ($row as $key => $value) {
                        $query->set($key, $this->getBinds($value), $index);
                    }
                }
                $backup[] = $query->getQuery(true);
            }
            return implode("\n\n", $backup);
        }
    }
}
/* Eden_Paypal_Error */
if (!class_exists('Eden_Paypal_Error')) {
    class Eden_Paypal_Error extends Eden_Error
    {
        public static function i($message = NULL, $code = 0)
        {
            $class = __CLASS__;
            return new $class($message, $code);
        }
    }
}
/* Eden_Paypal_Base */
if (!class_exists('Eden_Paypal_Base')) {
    class Eden_Paypal_Base extends Eden_Class
    {
        const VERSION = '84.0';
        const TEST_URL = 'https://api-3t.sandbox.paypal.com/nvp';
        const LIVE_URL = 'https://api-3t.paypal.com/nvp';
        const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';
        protected $_meta = array();
        protected $_url = NULL;
        protected $_user = NULL;
        protected $_password = NULL;
        protected $_signature = NULL;
        protected $_certificate = NULL;

        public function __construct($user, $password, $signature, $certificate, $live = false)
        {
            $this->_user = $user;
            $this->_password = $password;
            $this->_signature = $signature;
            $this->_certificate = $certificate;
            $this->_url = self::TEST_URL;
            $this->_baseUrl = self::TEST_URL;
            if ($live) {
                $this->_url = self::LIVE_URL;
                $this->_baseUrl = self::LIVE_URL;
            }
        }

        public function getMeta()
        {
            return $this->_meta;
        }

        protected function _accessKey($array)
        {
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    $array[$key] = $this->_accessKey($val);
                }
                if ($val == false || $val == NULL || empty($val) || !$val) {
                    unset($array[$key]);
                }
            }
            return $array;
        }

        protected function _request($method, array $query = array(), $post = true)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $default = array('USER' => $this->_user, 'PWD' => $this->_password, 'SIGNATURE' => $this->_signature, 'VERSION' => self::VERSION, 'METHOD' => $method);
            $query = http_build_query($query + $default);
            $curl = Eden_Curl::i()->setUrl($this->_baseUrl)->setVerbose(true)->setCaInfo($this->_certificate)->setPost(true)->setPostFields($query);
            $response = $curl->getQueryResponse();
            $this->_meta['url'] = $this->_baseUrl;
            $this->_meta['query'] = $query;
            $this->_meta['curl'] = $curl->getMeta();
            $this->_meta['response'] = $response;
            return $response;
        }
    }
}
/* Eden_Paypal_Authorization */
if (!class_exists('Eden_Paypal_Authorization')) {
    class Eden_Paypal_Authorization extends Eden_Paypal_Base
    {
        const DO_AUTHORIZATION = 'DoAuthorization';
        const DO_CAPTURE = 'DoCapture';
        const DO_REAUTHORIZATION = 'DoReauthorization';
        const DO_VOID = 'DoVoid';
        const TRANSACTION_ID = 'TRANSACTIONID';
        const AUTHORIZATION_ID = 'AUTHORIZATIONID';
        const ENTITY = 'TRANSACTIONENTITY';
        const ORDER = 'Order';
        const ACK = 'ACK';
        const SUCCESS = 'Success';
        const AMOUNT = 'AMT';
        const CURRENCY = 'CURRENCYCODE';
        const COMPLETE_TYPE = 'COMPLETETYPE';
        const COMPLETE = 'COMPLETE';
        const NO_COMPLETE = 'NoComplete';
        const NOTE = 'NOTE';
        protected $_amout = NULL;
        protected $_currency = NULL;
        protected $_completeType = NULL;
        protected $_note = NULL;
        protected $_transactionId = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function doAuthorization()
        {
            $query = array(self::TRANSACTION_ID => $this->_transactionId, self::AMOUNT => $this->_amount, self::ENTITY => self::ORDER, self::CURRENCY => $this->_currency);
            $response = $this->_request(self::DO_AUTHORIZATION, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response[self::TRANSACTION_ID];
            }
            return $response;
        }

        public function doCapture()
        {
            $query = array(self::AUTHORIZATION_ID => $this->_transactionId, self::AMOUNT => $this->_amount, self::CURRENCY => $this->_currency, self::COMPLETE_TYPE => $this->_completeType, self::NOTE => $this->_note);
            $response = $this->_request(self::DO_CAPTURE, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response[self::AUTHORIZATION_ID];
            }
            return $response;
        }

        public function doReAuthorization()
        {
            $query = array(self::AUTHORIZATION_ID => $this->_transactionId, self::AMOUNT => $this->_amount, self::CURRENCY => $this->_currency);
            $response = $this->_request(self::DO_REAUTHORIZATION, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response[self::AUTHORIZATION_ID];
            }
            return $response;
        }

        public function doVoid()
        {
            $query = array(self::AUTHORIZATION_ID => $this->_transactionId, self::NOTE => $this->_note);
            $response = $this->_request(self::DO_VOID, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response[self::AUTHORIZATION_ID];
            }
            return $response;
        }

        public function setAmount($amount)
        {
            Eden_Paypal_Error::i()->argument(1, 'int', 'float');
            $this->_amount = $amount;
            return $this;
        }

        public function setComplete()
        {
            $this->_completeType = self::COMPLETE;
            return $this;
        }

        public function setCurrency($currency)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_currency = $currency;
            return $this;
        }

        public function setNoComplete()
        {
            $this->_completeType = self::NO_COMPLETE;
            return $this;
        }

        public function setNote($note)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_note = $note;
            return $this;
        }

        public function setTransactionId($transactionId)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_transactionId = $transactionId;
            return $this;
        }
    }
}
/* Eden_Paypal_Billing */
if (!class_exists('Eden_Paypal_Billing')) {
    class Eden_Paypal_Billing extends Eden_Paypal_Base
    {
        const SET_AGREEMENT = 'SetCustomerBillingAgreement';
        const GET_AGREEMENT = 'GetBillingAgreementCustomerDetails';
        const TOKEN = 'TOKEN';
        const RETURN_URL = 'RETURNURL';
        const CANCEL_URL = 'CANCELURL';
        const ANY = 'Any';
        const INSTANT_ONLY = 'InstantOnly';
        const ACK = 'ACK';
        const SUCCESS = 'Success';
        const BILLING_TYPE = 'L_BILLINGTYPEn';
        const BILLING_DESC = 'L_BILLINGAGREEMENTDESCRIPTIONn';
        const PAYMENT_TYPE = 'L_PAYMENTTYPEn';
        const AGREEMENT_CUSTOM = 'L_BILLINGAGREEMENTCUSTOMn';
        const AMOUNT = 'AMT';
        protected $_token = NULL;
        protected $_amout = NULL;
        protected $_currency = NULL;
        protected $_completeType = NULL;
        protected $_billingType = NULL;
        protected $_billingDesc = NULL;
        protected $_paymentType = NULL;
        protected $_agreementCustom = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function getResponse($return, $cancel)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string');
            $query = array(self::RETURN_URL => $return, self::CANCEL_URL => $cancel, self::BILLING_TYPE => $this->_billingType, self::BILLING_DESC => $this->_billingDesc, self::PAYMENT_TYPE => $this->_paymentType, self::AGREEMENT_CUSTOM => $this->_agreementCustom);
            $response = $this->_request(self::SET_AGREEMENT, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                $this->_token = $response[self::TOKEN];
                if ($this->_token) {
                    return $this->_getAgreement();
                }
            }
            return $response;
        }

        public function setAgreementCustom($agreementCustom)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_agreementCustom = $agreementCustom;
            return $this;
        }

        public function setBillingDesc($billingDesc)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_billingDesc = $billingDesc;
            return $this;
        }

        public function setBillingType($billingType)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_billingType = $billingType;
            return $this;
        }

        public function setToAny()
        {
            $this->_paymentType = self::ANY;
            return $this;
        }

        public function setToInstantOnly()
        {
            $this->_paymentType = self::INSTANT_ONLY;
            return $this;
        }

        protected function _getAgreement()
        {
            $query = array(self::TOKEN => $this->_token);
            return $this->_request(self::GET_AGREEMENT, $query);
        }
    }
}
/* Eden_Paypal_Checkout */
if (!class_exists('Eden_Paypal_Checkout')) {
    class Eden_Paypal_Checkout extends Eden_Paypal_Base
    {
        const TEST_URL_CHECKOUT = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=%s';
        const LIVE_URL = 'https://www.paypal.com/webscr?cmd=_express-checkout&token=%s';
        const SET_METHOD = 'SetExpressCheckout';
        const GET_METHOD = 'GetExpressCheckoutDetails';
        const DO_METHOD = 'DoExpressCheckoutPayment';
        const DO_ADDRESS_VERIFY = 'AddressVerify';
        const CALL_BACK = 'Callback';
        const GET_BALANCE = 'GetBalance';
        const MASS_PAYMENT = 'MassPay';
        const GET_DETAIL = 'GetPalDetails';
        const SUCCESS = 'Success';
        const ACK = 'ACK';
        const TOKEN = 'TOKEN';
        const SALE = 'Sale';
        const ERROR = 'L_LONGMESSAGE0';
        const RETURN_URL = 'RETURNURL';
        const CANCEL_URL = 'CANCELURL';
        const TOTAL_AMOUNT = 'PAYMENTREQUEST_0_AMT';
        const SHIPPING_AMOUNT = 'PAYMENTREQUEST_0_SHIPPINGAMT';
        const CURRENCY = 'PAYMENTREQUEST_0_CURRENCYCODE';
        const ITEM_AMOUNT = 'PAYMENTREQUEST_0_ITEMAMT';
        const ITEM_NAME = 'L_PAYMENTREQUEST_0_NAME0';
        const ITEM_DESCRIPTION = 'L_PAYMENTREQUEST_0_DESC0';
        const ITEM_AMOUNT2 = 'L_PAYMENTREQUEST_0_AMT0';
        const QUANTITY = 'L_PAYMENTREQUEST_0_QTY0';
        const EMAIL = 'EMAIL';
        const STREET = 'STREET';
        const ZIP = 'ZIP';
        const RETURN_CURRENCIES = 'RETURNALLCURRENCIES';
        const EMAIL_SUBJECT = 'EMAILSUBJECT';
        const SOLUTION_TYPE = 'SOLUTIONTYPE';
        const PAYMENT_ACTION = 'PAYMENTACTION';
        const PAYER_ID = 'PAYERID';
        const TRANSACTION_ID = 'PAYMENTINFO_0_TRANSACTIONID';
        protected $_callBack = false;
        protected $_currencies = 0;
        protected $_amount = NULL;
        protected $_shippingAmount = NULL;
        protected $_currency = NULL;
        protected $_itemAmount = NULL;
        protected $_itemName = NULL;
        protected $_itemDescription = NULL;
        protected $_quantity = NULL;
        protected $_email = NULL;
        protected $_street = NULL;
        protected $_zip = NULL;
        protected $_emailSubject = NULL;
        protected $_solutionType = 'Sole';

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function __construct($user, $password, $signature, $certificate, $live = false)
        {
            parent::__construct($user, $password, $signature, $certificate, $live);
            $this->_url = self::TEST_URL_CHECKOUT;
            if ($live) {
                $this->_url = self::LIVE_URL;
            }
        }

        public function checkAddress()
        {
            $query = array(self::EMAIL => $this->_email, self::STREET => $this->_street, self::ZIP => $this->_zip);
            $response = $this->_request(self::DO_ADDRESS_VERIFY, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response;
            }
            return $response;
        }

        public function doMassPayment()
        {
            $query = array(self::EMAIL_SUBJECT => $this->_emailSubject, self::CURRENCY => $this->_currency);
            return $this->_request(self::MASS_PAYMENT, $query);
        }

        public function getBalance()
        {
            $query = array(self::RETURN_CURRENCIES => $this->_currencies);
            return $this->_request(self::GET_BALANCE, $query);
        }

        public function getDetail()
        {
            return $this->_request(self::GET_DETAIL);
        }

        public function getResponse($return, $cancel)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string');
            $query = array('PAYMENTREQUEST_0_PAYMENTACTION' => 'Authorization', self::SOLUTION_TYPE => $this->_solutionType, self::TOTAL_AMOUNT => $this->_amount, self::RETURN_URL => $return, self::CANCEL_URL => $cancel, self::SHIPPING_AMOUNT => $this->_shippingAmount, self::CURRENCY => $this->_currency, self::ITEM_AMOUNT => $this->_itemAmount, self::ITEM_NAME => $this->_itemName, self::ITEM_DESCRIPTION => $this->_itemDescription, self::ITEM_AMOUNT2 => $this->_itemAmount, self::QUANTITY => $this->_quantity,);
            $response = $this->_request(self::SET_METHOD, $query, false);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                if ($this->_callBack) {
                    $this->_token = $response[self::TOKEN];
                    return $this->_getCallback();
                }
            }
            return $response;
        }

        public function getTransactionId($payerId)
        {
            $this->_payer = $payerId;
            if (!$this->_token) {
                return NULL;
            }
            return $this->_getTransactionId();
        }

        public function setAmount($amount)
        {
            Eden_Paypal_Error::i()->argument(1, 'integer', 'float');
            $this->_amount = $amount;
            return $this;
        }

        public function setCallBack()
        {
            $this->_callBack = 'true';
            return $this;
        }

        public function setSolutionType($solutioType = 'Sole')
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_solutionType = $solutioType;
            return $this;
        }

        public function setCurrencies()
        {
            $this->_currencies = 1;
            return $this;
        }

        public function setCurrency($currency)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_currency = $currency;
            return $this;
        }

        public function setEmail($email)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_email = $email;
            return $this;
        }

        public function setEmailSubject($emailSubject)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_emailSubject = $emailSubject;
            return $this;
        }

        public function setItemAmount($itemAmount)
        {
            Eden_Paypal_Error::i()->argument(1, 'integer', 'float');
            $this->_itemAmount = $itemAmount;
            return $this;
        }

        public function setItemDescription($itemDescription)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_itemDescription = $itemDescription;
            return $this;
        }

        public function setItemName($itemName)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_itemName = $itemName;
            return $this;
        }

        public function setQuantity($quantity)
        {
            Eden_Paypal_Error::i()->argument(1, 'int');
            $this->_quantity = $quantity;
            return $this;
        }

        public function setShippingAmount($shippingAmount)
        {
            Eden_Paypal_Error::i()->argument(1, 'integer', 'float');
            $this->_shippingAmount = $shippingAmount;
            return $this;
        }

        public function setStreet($street)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_street = $street;
            return $this;
        }

        public function setToken($token, $redirect = false)
        {
            $this->_token = $token;
            if ($redirect == true) {
                header('Location: ' . sprintf($this->_url, urlencode($this->_token)));
                return;
            }
            return $this;
        }

        public function setZip($zip)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_zip = $zip;
            return $this;
        }

        protected function _getCallback()
        {
            $query = array(self::CURRENCY => $this->_currency, self::TOKEN => $this->_token);
            return $this->_request(self::CALL_BACK, $query);
        }

        protected function _getTransactionId()
        {
            $checkoutDetails = $this->_request(self::GET_METHOD, array(self::TOKEN => $this->_token));
            $query = array(self::TOKEN => $this->_token, self::PAYMENT_ACTION => self::SALE, self::PAYER_ID => $this->_payer, self::TOTAL_AMOUNT => $this->_amount, self::CURRENCY => $this->_currency);
            $response = $this->_request(self::DO_METHOD, $query);
            return $response;
        }
    }
}
/* Eden_Paypal_Direct */
if (!class_exists('Eden_Paypal_Direct')) {
    class Eden_Paypal_Direct extends Eden_Paypal_Base
    {
        const DIRECT_PAYMENT = 'DoDirectPayment';
        const NON_REFERENCED_CREDIT = 'DoNonReferencedCredit';
        const TRANSACTION_ID = 'TRANSACTIONID';
        const SALE = 'sale';
        const ACK = 'ACK';
        const SUCCESS = 'Success';
        const REMOTE_ADDRESS = 'REMOTE_ADDR';
        const IP_ADDRESS = 'IPADDRESS';
        const PAYMENT_ACTION = 'PAYMENTACTION';
        const CARD_TYPE = 'CREDITCARDTYPE';
        const CARD_NUMBER = 'ACCT';
        const EXPIRATION_DATE = 'EXPDATE';
        const CVV = 'CVV2';
        const FIRST_NAME = 'FIRSTNAME';
        const LAST_NAME = 'LASTNAME';
        const EMAIL = 'EMAIL';
        const COUNTRY_CODE = 'COUNTRYCODE';
        const STATE = 'STATE';
        const CITY = 'CITY';
        const STREET = 'STREET';
        const ZIP = 'ZIP';
        const AMOUNT = 'AMT';
        const CURRENCY = 'CURRENCYCODE';
        protected $_nonReferencedCredit = false;
        protected $_profileId = NULL;
        protected $_cardType = NULL;
        protected $_cardNumber = NULL;
        protected $_expirationDate = NULL;
        protected $_cvv2 = NULL;
        protected $_firstName = NULL;
        protected $_lastName = NULL;
        protected $_email = NULL;
        protected $_countryCode = NULL;
        protected $_state = NULL;
        protected $_city = NULL;
        protected $_street = NULL;
        protected $_zip = NULL;
        protected $_amout = NULL;
        protected $_currency = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function getResponse()
        {
            $query = array(self::IP_ADDRESS => $_SERVER[self::REMOTE_ADDRESS], self::PAYMENT_ACTION => self::SALE, self::CARD_TYPE => $this->_cardType, self::CARD_NUMBER => $this->_cardNumber, self::EXPIRATION_DATE => $this->_expirationDate, self::CVV => $this->_cvv2, self::FIRST_NAME => $this->_firstName, self::LAST_NAME => $this->_lastName, self::EMAIL => $this->_email, self::COUNTRY_CODE => $this->_countryCode, self::STATE => $this->_state, self::CITY => $this->_city, self::STREET => $this->_street, self::ZIP => $this->_zip, self::AMOUNT => $this->_amount, self::CURRENCY => $this->_currency);
            if ($this->_setNonReferencedCredit) {
                return $this->_setNonReferencedCredit($query);
            }
            return $this->_setDirectPayment($query);
        }

        public function setAmount($amount)
        {
            Eden_Paypal_Error::i()->argument(1, 'int', 'float');
            $this->_amount = $amount;
            return $this;
        }

        public function setCardNumber($cardNumber)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cardNumber = $cardNumber;
            return $this;
        }

        public function setCardType($cardType)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cardType = $cardType;
            return $this;
        }

        public function setCity($city)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_city = $city;
            return $this;
        }

        public function setCountryCode($countryCode)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_countryCode = $countryCode;
            return $this;
        }

        public function setCurrency($currency)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_currency = $currency;
            return $this;
        }

        public function setCvv2($cvv2)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cvv2 = $cvv2;
            return $this;
        }

        public function setEmail($email)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_email = $email;
            return $this;
        }

        public function setExpirationDate($expirationDate)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_expirationDate = $expirationDate;
            return $this;
        }

        public function setFirstName($firstName)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_firstName = $firstName;
            return $this;
        }

        public function setLastName($lastName)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_lastName = $lastName;
            return $this;
        }

        public function setNonReferencedCredit()
        {
            $this->_setNonReferencedCredit = 'true';
            return $this;
        }

        public function setState($state)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_state = $state;
            return $this;
        }

        public function setStreet($street)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_street = $street;
            return $this;
        }

        public function setZip($zip)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_zip = $zip;
            return $this;
        }

        protected function _setDirectPayment($query)
        {
            Eden_Paypal_Error::i()->argument(1, 'array');
            $response = $this->_request(self::DIRECT_PAYMENT, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response[self::TRANSACTION_ID];
            }
            return $response;
        }

        protected function _setNonReferencedCredit($query)
        {
            Eden_Paypal_Error::i()->argument(1, 'array');
            $response = $this->_request(self::NON_REFERENCED_CREDIT, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response[self::TRANSACTION_ID];
            }
            return $response;
        }
    }
}
/* Eden_Paypal_Recurring */
if (!class_exists('Eden_Paypal_Recurring')) {
    class Eden_Paypal_Recurring extends Eden_Paypal_Base
    {
        const RECURRING_PAYMENT = 'CreateRecurringPaymentsProfile';
        const GET_DETAIL = 'GetRecurringPaymentsProfileDetails';
        const MANAGE_STATUS = 'ManageRecurringPaymentsProfileStatus';
        const BILL_AMOUNT = 'BillOutstandingAmount';
        const PROFILE_ID = 'PROFILEID';
        const SALE = 'sale';
        const ACK = 'ACK';
        const SUCCESS = 'Success';
        const ERROR = 'L_LONGMESSAGE0';
        const REMOTE_ADDRESS = 'REMOTE_ADDR';
        const IP_ADDRESS = 'IPADDRESS';
        const PAYMENT_ACTION = 'PAYMENTACTION';
        const DAY = 'Day';
        const WEEK = 'Week';
        const SEMI_MONTH = 'SemiMonth';
        const MONTH = 'Month';
        const YEAR = 'Year';
        const CANCEL = 'Cancel';
        const SUSPEND = 'Suspend';
        const REACTIVATE = 'Reactivate';
        const CARD_TYPE = 'CREDITCARDTYPE';
        const CARD_NUMBER = 'ACCT';
        const EXPIRATION_DATE = 'EXPDATE';
        const CVV = 'CVV2';
        const FIRST_NAME = 'FIRSTNAME';
        const LAST_NAME = 'LASTNAME';
        const EMAIL = 'EMAIL';
        const COUNTRY_CODE = 'COUNTRYCODE';
        const STATE = 'STATE';
        const CITY = 'CITY';
        const STREET = 'STREET';
        const ZIP = 'ZIP';
        const AMOUNT = 'AMT';
        const CURRENCY = 'CURRENCYCODE';
        const DESCRIPTION = 'DESC';
        const START_DATE = 'PROFILESTARTDATE';
        const BILLING_PERIOD = 'BILLINGPERIOD';
        const BILLING_FREQUENCY = 'BILLINGFREQUENCY';
        protected $_profileId = NULL;
        protected $_cardType = NULL;
        protected $_cardNumber = NULL;
        protected $_expirationDate = NULL;
        protected $_cvv2 = NULL;
        protected $_firstName = NULL;
        protected $_lastName = NULL;
        protected $_email = NULL;
        protected $_countryCode = NULL;
        protected $_state = NULL;
        protected $_city = NULL;
        protected $_street = NULL;
        protected $_zip = NULL;
        protected $_amout = NULL;
        protected $_currency = NULL;
        protected $_action = NULL;
        protected $_note = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function cancel()
        {
            $this->_action = self::CANCEL;
            return $this;
        }

        public function getBilling()
        {
            $query = array(self::PROFILE_ID => $this->_profileId, self::AMOUNT => $this->_amount, self::NOTE => $this->_note);
            $response = $this->_request(self::BILL_AMOUNT, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response;
            }
            return $response;
        }

        public function getResponse()
        {
            $query = array(self::IP_ADDRESS => $_SERVER[self::REMOTE_ADDRESS], self::PAYMENT_ACTION => self::SALE, self::CARD_TYPE => $this->_cardType, self::CARD_NUMBER => $this->_cardNumber, self::EXPIRATION_DATE => $this->_expirationDate, self::CVV => $this->_cvv2, self::FIRST_NAME => $this->_firstName, self::LAST_NAME => $this->_lastName, self::EMAIL => $this->_email, self::COUNTRY_CODE => $this->_countryCode, self::STATE => $this->_state, self::CITY => $this->_city, self::STREET => $this->_street, self::ZIP => $this->_zip, self::AMOUNT => $this->_amount, self::CURRENCY => $this->_currency, self::DESCRIPTION => $this->_description, self::START_DATE => date('Y-m-d H:i:s'), self::BILLING_PERIOD => $this->_billingPeriod, self::BILLING_FREQUENCY => $this->_billingFrequency);
            $response = $this->_request(self::RECURRING_PAYMENT, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                $this->_profileId = $response[self::PROFILE_ID];
                return $this->_getDetails();
            }
            return $response;
        }

        public function getStatus()
        {
            $query = array(self::PROFILE_ID => $this->_profileId, self::ACTION => $this->_action, self::NOTE => $this->_note);
            $response = $this->_request(self::MANAGE_STATUS, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response;
            }
            return $response;
        }

        public function reactivate()
        {
            $this->_action = self::REACTIVATE;
            return $this;
        }

        public function setAmount($amount)
        {
            Eden_Paypal_Error::i()->argument(1, 'int', 'float');
            $this->_amount = $amount;
            return $this;
        }

        public function setBillingFrequency($billingFrequency)
        {
            Eden_Paypal_Error::i()->argument(1, 'int');
            $this->_billingFrequency = $billingFrequency;
            return $this;
        }

        public function setCardNumber($cardNumber)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cardNumber = $cardNumber;
            return $this;
        }

        public function setCardType($cardType)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cardType = $cardType;
            return $this;
        }

        public function setCity($city)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_city = $city;
            return $this;
        }

        public function setCountryCode($countryCode)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_countryCode = $countryCode;
            return $this;
        }

        public function setCurrency($currency)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_currency = $currency;
            return $this;
        }

        public function setCvv2($cvv2)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cvv2 = $cvv2;
            return $this;
        }

        public function setDay()
        {
            $this->_billingPeriod = self::DAY;
            return $this;
        }

        public function setDescription($description)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_description = $description;
            return $this;
        }

        public function setEmail($email)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_email = $email;
            return $this;
        }

        public function setExpirationDate($expirationDate)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_expirationDate = $expirationDate;
            return $this;
        }

        public function setFirstName($firstName)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_firstName = $firstName;
            return $this;
        }

        public function setLastName($lastName)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_lastName = $lastName;
            return $this;
        }

        public function setMonth()
        {
            $this->_billingPeriod = self::MONTH;
            return $this;
        }

        public function setNote($note)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_note = $note;
            return $this;
        }

        public function setProfileId($profileId)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_profileId = $profileId;
            return $this;
        }

        public function setSemiMonth()
        {
            $this->_billingPeriod = self::SEMI_MONTH;
            return $this;
        }

        public function setState($state)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_state = $state;
            return $this;
        }

        public function setStatus($status)
        {
            $this->_status = $status;
            return $this;
        }

        public function setStreet($street)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_street = $street;
            return $this;
        }

        public function setWeek()
        {
            $this->_billingPeriod = self::WEEK;
            return $this;
        }

        public function setYear()
        {
            $this->_billingPeriod = self::YEAR;
            return $this;
        }

        public function setZip($zip)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_zip = $zip;
            return $this;
        }

        public function suspend()
        {
            $this->_action = self::SUSPEND;
            return $this;
        }

        protected function _getDetails()
        {
            $query = array(self::PROFILE_ID => $this->_profileId);
            $response = $this->_request(self::GET_DETAIL, $query);
            if (isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
                return $response;
            }
            return $response;
        }
    }
}
/* Eden_Paypal_Transaction */
if (!class_exists('Eden_Paypal_Transaction')) {
    class Eden_Paypal_Transaction extends Eden_Paypal_Base
    {
        const GET_DETAIL = 'GetTransactionDetails';
        const MANAGE_STATUS = 'ManagePendingTransactionStatus';
        const REFUND_TRANSACTION = 'RefundTransaction';
        const SEARCH = 'TransactionSearch';
        const ACTION = 'ACTION';
        const REFUND_TYPE = 'REFUNDTYPE';
        const STORE_ID = 'STOREID';
        const START = 'STARTDATE';
        const END = 'ENDDATE';
        const EMAIL = 'EMAIL';
        const RECEIVER = 'RECEIVER';
        const RECEIPT_ID = 'RECEIPTID';
        const TRANSACTION_ID = 'TRANSACTIONID';
        const CARD_NUMBER = 'ACCT';
        const AMOUNT = 'AMT';
        const CURRENCY = 'CURRENCYCODE';
        const STATUS = 'STATUS';
        const NOTE = 'NOTE';
        protected $_action = NULL;
        protected $_refundType = NULL;
        protected $_amount = NULL;
        protected $_currency = NULL;
        protected $_note = NULL;
        protected $_storeId = NULL;
        protected $_start = NULL;
        protected $_end = NULL;
        protected $_email = NULL;
        protected $_receiver = NULL;
        protected $_receiptId = NULL;
        protected $_transactionId = NULL;
        protected $_cardNumber = NULL;
        protected $_status = NULL;

        public static function i()
        {
            return self::_getMultiple(__CLASS__);
        }

        public function getDetail()
        {
            $query = array(self::TRANSACTION_ID => $this->_transactionId);
            $response = $this->_request(self::GET_DETAIL, $query);
            return $response;
        }

        public function manageStatus()
        {
            $query = array(self::TRANSACTION_ID => $this->_transactionId, self::ACTION => $this->_action);
            $response = $this->_request(self::MANAGE_STATUS, $query);
            return $response;
        }

        public function refundTransaction()
        {
            $query = array(self::TRANSACTION_ID => $this->_transactionId, self::REFUND_TYPE => $this->_refundType, self::AMOUNT => $this->_amount, self::CURRENCY => $this->_currency, self::NOTE => $this->_note, self::STORE_ID => $this->_storeId);
            $response = $this->_request(self::REFUND_TRANSACTION, $query);
            return $response;
        }

        public function search()
        {
            $query = array(self::START => $this->_start, self::END => $this->_end, self::EMAIL => $this->_email, self::RECEIVER => $this->_receiver, self::RECEIPT_ID => $this->_receiptId, self::TRANSACTION_ID => $this->_transactionId, self::CARD_NUMBER => $this->_cardNumber, self::AMOUNT => $this->_amount, self::CURRENCY => $this->_currency, self::STATUS => $this->_status);
            $response = $this->_request(self::SEARCH, $query);
            return $response;
        }

        public function setAction($action)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_action = $action;
            return $this;
        }

        public function setAmount($amount)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_amount = $amount;
            return $this;
        }

        public function setCardNumber($cardNumber)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_cardNumber = $cardNumber;
            return $this;
        }

        public function setCurrency($currency)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_currency = $currency;
            return $this;
        }

        public function setEmail($email)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_email = $email;
            return $this;
        }

        public function setEndDate($end)
        {
            $date = strtotime($end);
            $this->_end = gmdate('Y-m-d\TH:i:s\Z', $date);
            return $this;
        }

        public function setNote($note)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_note = $note;
            return $this;
        }

        public function setReceiptId($receiptId)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_receiptId = $receiptId;
            return $this;
        }

        public function setReceiver($receiver)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_receiver = $receiver;
            return $this;
        }

        public function setRefundType($refundType)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_refundType = $refundType;
            return $this;
        }

        public function setStartDate($start)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $date = strtotime($start);
            $this->_start = gmdate('Y-m-d\TH:i:s\Z', $date);
            return $this;
        }

        public function setStatus($status)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_status = $status;
            return $this;
        }

        public function setStoreId($storeId)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_storeId = $storeId;
            return $this;
        }

        public function setTransactionId($transactionId)
        {
            Eden_Paypal_Error::i()->argument(1, 'string');
            $this->_transactionId = $transactionId;
            return $this;
        }
    }
}
/* Eden_Paypal */
if (!class_exists('Eden_Paypal')) {
    class Eden_Paypal extends Eden_Class
    {
        const PEM = '/paypal/cacert.pem';

        public static function i()
        {
            return self::_getSingleton(__CLASS__);
        }

        public function authorization($user, $password, $signature, $certificate = NULL)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null');
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Authorization::i($user, $password, $signature, $certificate);
        }

        public function billing($user, $password, $signature, $certificate = NULL)
        {
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Billing::i($user, $password, $signature, $certificate);
        }

        public function button($user, $password, $signature, $certificate = NULL)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null');
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Button::i($user, $password, $signature, $certificate);
        }

        public function checkout($user, $password, $signature, $certificate = NULL, $live = false)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null');
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Checkout::i($user, $password, $signature, $certificate, $live);
        }

        public function direct($user, $password, $signature, $certificate = NULL)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null');
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Direct::i($user, $password, $signature, $certificate);
        }

        public function recurring($user, $password, $signature, $certificate = NULL)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null');
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Recurring::i($user, $password, $signature, $certificate);
        }

        public function transaction($user, $password, $signature, $certificate = NULL)
        {
            Eden_Paypal_Error::i()->argument(1, 'string')->argument(2, 'string')->argument(3, 'string')->argument(4, 'string', 'null');
            if (!is_string($certificate)) {
                $certificate = dirname(__FILE__) . self::PEM;
            }
            return Eden_Paypal_Transaction::i($user, $password, $signature, $certificate);
        }
    }
}
