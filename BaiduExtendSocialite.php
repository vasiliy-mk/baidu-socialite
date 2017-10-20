<?php

namespace Vasiliy\Baidu;

use SocialiteProviders\Manager\SocialiteWasCalled;

class BaiduExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'baidu', __NAMESPACE__.'\Provider'
        );
    }
}
