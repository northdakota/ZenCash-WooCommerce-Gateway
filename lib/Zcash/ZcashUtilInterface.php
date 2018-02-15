<?php
/**
 * Created by HeximCZ
 * Date: 5/28/17 5:42 PM
 */

namespace Hexim\HeximZcashBundle\Zcash;

interface ZcashUtilInterface
{
    public function validateAddress($address);
    public function z_validateAddress($address);
}