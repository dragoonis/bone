<?php declare(strict_types=1);

namespace Bone\Server;

use Bone\Mvc\Router\NotFoundException;
use Locale;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\I18n\Translator\Translator;

class I18nHandler
{
    const REGEX_LOCALE = '#^/(?P<locale>[a-z]{2}[-_][a-zA-Z]{2})(?:/|$)#';

    /** @var Translator$translator */
    private $translator;

    /** @var array $supportedLocales */
    private $supportedLocales;

    /**
     * InternationalisationMiddleware constructor.
     * @param  $helper
     * @param string|null $defaultLocale
     */
    public function __construct(Translator $translator, array $supportedLocales)
    {
        $this->translator = $translator;
        $this->supportedLocales = $supportedLocales;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     * @throws NotFoundException
     */
    public function handleI18n(ServerRequestInterface $request): ServerRequestInterface
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if (! preg_match(self::REGEX_LOCALE, $path, $matches)) {
            $path = '/' . Locale::getDefault() . $path;
            $query = $request->getUri()->getQuery();
            $query = $query !== null ? '?' . $query : null;
            $e = new NotFoundException($path . $query);
            $e->setRequest($request);
            
            throw $e;
        }

        $locale = $matches['locale'];

        if (in_array($locale, $this->supportedLocales)) {
            $locale = Locale::canonicalize($locale);
            Locale::setDefault($locale);
            $this->translator->setLocale($locale);
            $path = substr($path, strlen($locale) + 1);
            $uri = $uri->withPath($path);
            $request = $request->withUri($uri);
        }

        return $request;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function removeI18n(ServerRequestInterface $request): ServerRequestInterface
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if (! preg_match(self::REGEX_LOCALE, $path, $matches)) {
            return $request;
        }

        $locale = $matches['locale'];
        $path = substr($path, strlen($locale) + 1);
        $uri = $uri->withPath($path);
        $request = $request->withUri($uri);

        return $request;
    }
}