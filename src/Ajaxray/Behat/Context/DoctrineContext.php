<?php
/*
 * This file is part common context files of Ajaxray
 *
 * (c) Anis Uddin Ahmad <anisniit@gmail.com>
 */


namespace Ajaxray\Behat\Context;


use Ajaxray\Common\Helper\Dir;

trait DoctrineContext
{
    /**
     * @BeforeScenario
     */
    public function setupDb()
    {
        $dbpath = $this->getContainer()->getParameter('test_sqlite_path');

        if(! is_file($dbpath)) {
            // Create File
            Dir::makeWritable(dirname($dbpath));
            touch($dbpath);

            // Prepare database
            chdir($this->getKernel()->getRootDir());
            exec('php console doctrine:database:create --env=test');
            exec('php console doctrine:schema:create --env=test');

            // Create Super Admin
            $helper = $this->getContainer()->get('fos_user.util.user_manipulator');
            $helper->create('admin', '123456', 'anis.programmer@gmail.com', true, true);
        }
    }

    /**
     * @Given /^database in default state$/
     */
    public function databaseInDefaultState()
    {
        $this->clearData();
        $this->executeSQLScript('default.sql');
    }

    /**
     * @Given /^database is empty$/
     */
    public function clearData()
    {
        $this->executeSQLScript('teardown.sql');
    }

    public function executeSQLScript($scriptName)
    {
        $dbpath = $this->getContainer()->getParameter('test_sqlite_path');
        $clearScript = $this->getKernel()->getRootDir(). '/data/scripts/'. $scriptName;

        exec("sqlite3 $dbpath < $clearScript");
    }
} 