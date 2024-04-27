<?php

namespace App\Services\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Keyword;

class BasePolicy extends Basic
{

    private const STORAGE_HOST = "http://storage.c2dl.info";
    private const LOCALHOST_DEV_VITE_HTTP = "http://localhost:5173";
    private const LOCALHOST_DEV_VITE_WS = "ws://localhost:5173";

    public function configure()
    {
        if ((config('app.debug') == false) || (config('app.csp-in-debug') == true)) {
            $this
                //->addDirective(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE)
                //->addDirective(Directive::BLOCK_ALL_MIXED_CONTENT, Value::NO_VALUE)
                ->addDirective(Directive::BASE, Keyword::SELF)
                ->addDirective(Directive::CONNECT, Keyword::SELF)
                ->addDirective(Directive::DEFAULT, Keyword::SELF)
                ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
                ->addDirective(Directive::IMG, [Keyword::SELF, BasePolicy::STORAGE_HOST])
                ->addDirective(Directive::MEDIA, Keyword::SELF)
                ->addDirective(Directive::OBJECT, Keyword::NONE)
                ->addDirective(Directive::SCRIPT, Keyword::SELF)
                ->addDirective(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE])
                ->addDirective(Directive::FONT, [Keyword::SELF, BasePolicy::STORAGE_HOST])
                ->addNonceForDirective(Directive::SCRIPT);
            // ->addNonceForDirective(Directive::STYLE)
        }
        else {
            $this
                ->addDirective(Directive::BASE,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP])
                ->addDirective(Directive::DEFAULT,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP])
                ->addDirective(Directive::SCRIPT,
                    [
                        Keyword::SELF, Keyword::UNSAFE_INLINE,
                        BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST
                    ])
                ->addDirective(Directive::STYLE,
                    [
                        Keyword::SELF, Keyword::UNSAFE_INLINE,
                        BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST
                    ])
                ->addDirective(Directive::IMG,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST])
                ->addDirective(Directive::FONT,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST])
                ->addDirective(Directive::CONNECT,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_WS]);
        }
    }
}
