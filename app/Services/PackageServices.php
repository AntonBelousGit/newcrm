<?php

namespace App\Services;

use App\Repositories\PackageRepositories;

class PackageServices
{
    protected $packageRepositories;

    public function __construct(PackageRepositories $packageRepositories){
        $this->packageRepositories = $packageRepositories;
    }

    public function duplicate($new_order,$order)
    {
        $this->packageRepositories->duplicate( $new_order,$order);
    }

}
