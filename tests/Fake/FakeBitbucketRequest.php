<?php

namespace Tests\Fake;

use Deployer\Request;

class FakeBitbucketRequest extends Request
{

    public function getPayload()
    {
        return json_decode('{"repository":{"name":"testing-repository"},"push":{"changes":[]}}');
    }
}