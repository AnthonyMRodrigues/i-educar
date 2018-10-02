<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LegacyController extends Controller
{
    /**
     * Return i-Educar legacy code path.
     *
     * @return string
     */
    private function getLegacyPath()
    {
        return base_path(config('legacy.path'));
    }

    /**
     * Return i-Educar original bootstrap file.
     *
     * @return string
     */
    private function getLegacyBootstrapFile()
    {
        return $this->getLegacyPath() . '/includes/bootstrap.php';
    }

    /**
     * Define which errors and exceptions are shown.
     *
     * @return void
     */
    private function configureErrorsAndExceptions()
    {
        ini_set('display_errors', 'off');

        error_reporting(0);

        restore_error_handler();

        restore_exception_handler();
    }

    /**
     * Load bootstrap file, if not found, throw a HttpException with HTTP error
     * code 500 Server Internal Error.
     *
     * @return void
     *
     * @throws HttpException
     */
    private function loadLegacyBootstrapFile()
    {
        $filename = $this->getLegacyBootstrapFile();

        if (false === file_exists($filename)) {
            throw new HttpException(500, 'Legacy bootstrap file not found.');
        }

        require_once $filename;
    }

    /**
     * Load legacy route file, if not found, throw a HttpException with HTTP
     * error code 404 Not Found.
     *
     * @param string $filename
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    private function loadLegacyFile($filename)
    {
        $legacyFile = $this->getLegacyPath() . '/' . $filename;

        if (false === file_exists($legacyFile)) {
            throw new NotFoundHttpException('Legacy file not found.');
        }

        require_once $legacyFile;
    }

    /**
     * Return all HTTP headers created during this request that will returned
     * in response.
     *
     * @return array
     */
    private function getHttpHeaders()
    {
        $headers = [];

        foreach (headers_list() as $header) {
            $header = explode(':', $header);

            $name = ltrim($header[0], ' ');
            $value = ltrim($header[1], ' ');

            $headers[$name] = $value;
        }

        return $headers;
    }

    /**
     * Return the current HTTP status code.
     *
     * @return int
     */
    private function getHttpStatusCode()
    {
        return http_response_code();
    }

    /**
     * Start session, configure errors and exceptions and load necessary files
     * to run legacy code.
     *
     * @param string $filename
     *
     * @return Response
     */
    private function requireFileFromLegacy($filename)
    {
        $this->startLegacySession();
        $this->configureErrorsAndExceptions();
        $this->loadLegacyBootstrapFile();

        ob_start();

        $this->loadLegacyFile($filename);

        $content = ob_get_contents();

        ob_end_clean();

        return new Response(
            $content, $this->getHttpStatusCode(), $this->getHttpHeaders()
        );
    }

    /**
     * Start session.
     *
     * @return void
     */
    private function startLegacySession()
    {
        session_start();
    }

    /**
     * Load intranet route file and generate a response.
     *
     * @param string $uri
     *
     * @return Response
     */
    public function intranet($uri)
    {
        return $this->requireFileFromLegacy('intranet/' . $uri);
    }

    /**
     * Load module route file and generate a response.
     *
     * @return Response
     */
    public function module()
    {
        return $this->requireFileFromLegacy('module/index.php');
    }

    /**
     * Load modules route file and generate a response.
     *
     * @param string $uri
     *
     * @return Response
     */
    public function modules($uri)
    {
        return $this->requireFileFromLegacy('modules/' . $uri);
    }
}
