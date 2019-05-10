<?php
namespace Slim\Middleware;
class ETag {

    /**
     * Construct class
     * 
     * @param string $etag  this is the value of old/current etag
     * @param string $type  this is the type of etag "strong|weak". default is "strong"
     */
    public function __construct($etag,$type='strong'){
        $this->etag = $etag;
        $this->type = $type;
    }

    /**
     * ETag middleware invokable class
     * 
     * @param \Psr\Http\Message\ServerRequestInterface  $request    PSR7 request
     * @param \Psr\Http\Message\ResponseInterface       $response   PSR7 response
     * @param callable                                  $next       Next middleware
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        if($request->isGet() || $request->isHead()){
            $this->etag = '"' . $this->etag . '"';

            if ($this->type === 'weak') {
                $this->etag = 'W/' . $this->etag;
            }

            if($this->etag == $request->getHeaderLine('ETag')){
                return $response->withStatus(304)->withHeader('ETag', $this->etag);   
            }
        }
        $response = $next($request, $response);
        return $response;
    }

}
