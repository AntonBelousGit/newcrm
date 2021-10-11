<?php

namespace App\Services;

use App\Repositories\PackageRepositories;

class PackageServices
{
    protected $packageRepositories;

    public function __construct(PackageRepositories $packageRepositories){
        $this->packageRepositories = $packageRepositories;
    }

    public function dublicate($new_order,$order)
    {
        $this->packageRepositories->dublicate( $new_order,$order);
    }

}
