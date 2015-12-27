<?php

namespace BVDS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BVDSUserBundle extends Bundle
{
	public function getParent()
  	{
    	return 'FOSUserBundle';
  	}
}
