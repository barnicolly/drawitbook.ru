<?php
namespace App\Http\Middleware;

use Waavi\Translation\Middleware\TranslationMiddleware;
use Closure;

class CustomTranslationMiddleware extends TranslationMiddleware
{

    public function handle($request, Closure $next, $segment = 0)
    {
        // Ignores all non GET requests:
        if ($request->method() !== 'GET') {
            return $next($request);
        }
        $ignoreSegments = [
            '_debugbar',
        ];
        if (in_array($request->segment(1), $ignoreSegments, true)) {
            return $next($request);
        }

        $currentUrl    = $request->getUri();
        $uriLocale     = $this->uriLocalizer->getLocaleFromUrl($currentUrl, $segment);
        $defaultLocale = $this->config->get('app.locale');

        // If a locale was set in the url:
        if ($uriLocale) {
            $currentLanguage     = $this->languageRepository->findByLocale($uriLocale);
            $selectableLanguages = $this->languageRepository->allExcept($uriLocale);
            $altLocalizedUrls    = [];
            foreach ($selectableLanguages as $lang) {
                $altLocalizedUrls[] = [
                    'locale' => $lang->locale,
                    'name'   => $lang->name,
                    'url'    => $this->uriLocalizer->localize($currentUrl, $lang->locale, $segment),
                ];
            }

            // Set app locale
            $this->app->setLocale($uriLocale);

            // Share language variable with views:
            $this->viewFactory->share('currentLanguage', $currentLanguage);
            $this->viewFactory->share('selectableLanguages', $selectableLanguages);
            $this->viewFactory->share('altLocalizedUrls', $altLocalizedUrls);

            // Set locale in session:
            if ($request->hasSession() && $request->session()->get('waavi.translation.locale') !== $uriLocale) {
                $request->session()->put('waavi.translation.locale', $uriLocale);
            }
            return $next($request);
        }

        // If no locale was set in the url, check the session locale
        if ($request->hasSession() && $sessionLocale = $request->session()->get('waavi.translation.locale')) {
            if ($this->languageRepository->isValidLocale($sessionLocale)) {
                return redirect()->to($this->uriLocalizer->localize($currentUrl, $sessionLocale, $segment), 301);
            }
        }

        // If no locale was set in the url, check the browser's locale:
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        if ($this->languageRepository->isValidLocale($browserLocale)) {
            return redirect()->to($this->uriLocalizer->localize($currentUrl, $browserLocale, $segment), 301);
        }

        // If not, redirect to the default locale:
        // Keep flash data.
        if ($request->hasSession()) {
            $request->session()->reflash();
        }
        return redirect()->to($this->uriLocalizer->localize($currentUrl, $defaultLocale, $segment), 301);
    }
}