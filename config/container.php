<?php

use Heystack\Core\Console\Command\GenerateContainer;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

$containerName = 'HeystackServiceContainer' . Director::get_environment_type();
$containerFile = HEYSTACK_BASE_PATH . "/cache/$containerName.php";

if (!file_exists($containerFile)) {
    (new GenerateContainer())->run(
        new ArrayInput([]),
        new NullOutput()
    );
}

require_once $containerFile;
