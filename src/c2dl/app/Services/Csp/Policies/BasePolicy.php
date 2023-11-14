<?php

namespace App\Services\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Value;
use Spatie\Csp\Keyword;

class BasePolicy extends Basic
{
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
                ->addDirective(Directive::IMG, [Keyword::SELF, "storage.c2dl.info"])
                ->addDirective(Directive::MEDIA, Keyword::SELF)
                ->addDirective(Directive::OBJECT, Keyword::NONE)
                ->addDirective(Directive::SCRIPT, Keyword::SELF)
                ->addDirective(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE])
                ->addDirective(Directive::FONT, [Keyword::SELF, "storage.c2dl.info"])
                ->addNonceForDirective(Directive::SCRIPT);
            // ->addNonceForDirective(Directive::STYLE)
        }
        else {
            $this
                ->addDirective(Directive::BASE, Keyword::SELF)
                ->addDirective(Directive::DEFAULT, Keyword::SELF)
                ->addDirective(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_INLINE, "storage.c2dl.info"])
                ->addDirective(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE, "storage.c2dl.info"])
                ->addDirective(Directive::IMG, [Keyword::SELF, "storage.c2dl.info"])
                ->addDirective(Directive::FONT, [Keyword::SELF, "storage.c2dl.info"]);
        }
    }
}
