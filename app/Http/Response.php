<?php

namespace App\Http;

class Response
{
    /**
     * Http status code
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Response header
     * @var array
     */
    private $headers = [];

    /**
     * Returned content type
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Response content
     * @var mixed
     */
    private $content;

    /**
     * Method to init class and define values
     * @param integer
     * @param mixed
     * @param string
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Method to change contentType of response
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Method to add a reg in response header
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Method to send the headers to navigator
     */
    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        //SEND ALL HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Method to send response to user
     */
    public function sendResponse()
    {

        // SEND HEADERS
        $this->sendHeaders();

        // PRINT CONTENT
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            case 'application/json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
        }
    }
}
