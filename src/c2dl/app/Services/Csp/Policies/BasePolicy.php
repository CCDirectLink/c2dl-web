<?php

namespace App\Services\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class BasePolicy implements Preset
{

    private const string STORAGE_HOST = "https://storage.c2dl.info";
    private const string LOCALHOST_DEV_VITE_HTTP = "http://localhost:5173";
    private const string LOCALHOST_DEV_VITE_WS = "ws://localhost:5173";

    public function configure(Policy $policy): void
    {
        if ( ! config('app.debug') || config('app.csp-in-debug')) {
            $policy
                //->addDirective(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE)
                //->addDirective(Directive::BLOCK_ALL_MIXED_CONTENT, Value::NO_VALUE)
                ->add(Directive::BASE, Keyword::SELF)
                ->add(Directive::CONNECT, Keyword::SELF)
                ->add(Directive::DEFAULT, Keyword::SELF)
                ->add(Directive::FORM_ACTION, Keyword::SELF)
                ->add(Directive::IMG, [Keyword::SELF, BasePolicy::STORAGE_HOST])
                ->add(Directive::MEDIA, Keyword::SELF)
                ->add(Directive::OBJECT, Keyword::NONE)
                ->add(Directive::SCRIPT, Keyword::SELF)
                ->add(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE])
                ->add(Directive::FONT, [Keyword::SELF, BasePolicy::STORAGE_HOST])
                ->addNonce(Directive::SCRIPT);
            // ->addNonceForDirective(Directive::STYLE)
        }
        else {
            $policy
                ->add(Directive::BASE,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP])
                ->add(Directive::DEFAULT,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP])
                ->add(Directive::SCRIPT,
                    [
                        Keyword::SELF, Keyword::UNSAFE_INLINE,
                        BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST
                    ])
                ->add(Directive::STYLE,
                    [
                        Keyword::SELF, Keyword::UNSAFE_INLINE,
                        BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST
                    ])
                ->add(Directive::IMG,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST])
                ->add(Directive::FONT,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_HTTP, BasePolicy::STORAGE_HOST])
                ->add(Directive::CONNECT,
                    [Keyword::SELF, BasePolicy::LOCALHOST_DEV_VITE_WS]);
        }
    }
}
