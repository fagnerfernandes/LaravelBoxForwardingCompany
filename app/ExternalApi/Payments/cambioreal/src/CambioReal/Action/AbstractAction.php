<?php namespace CambioReal\Action;

/**
 * The abstract action class
 *
 * @author Deivide Vian <dvdvian@gmail.com>
 */
abstract class AbstractAction {

    /**
     * Associative array of params
     * @var array
     */
    protected $params = array();

    /**
     * The HTTP method
     * @var string
     */
    protected $method = 'POST';

    /**
     * The action URL address
     * @var string
     */
    protected $action = null;

    /**
     * The response type - HTML or JSON
     * @var string
     */
    protected $_responseType = 'JSON';

    /**
     * Validates the request parameters
     * @param CambioReal\Action\Validator $validator The validator instance
     * @return mixed
     * @throws InvalidArgumentException
     */
    abstract protected function validate($validator);

    /**
     * Executes the action in the CambioReal API
     * @param  array $params The request parameters
     * @return mixed
     */
    public function execute($params)
    {
        $this->params = $params;
        $this->validate(new \CambioReal\Action\Validator($this->params));

        // Get the HTTP request from the registry
        $httpRequest = \CambioReal\Config::getHttpRequest();
        $request = new $httpRequest();
        $request->setParams($this->params)
               ->setMethod($this->method)
               ->setAction($this->action)
               ->setResponseType($this->_responseType);

        return $request->send();
    }
    
}
