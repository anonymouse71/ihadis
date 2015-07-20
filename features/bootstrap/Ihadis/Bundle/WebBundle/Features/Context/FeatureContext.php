<?php

namespace Ihadis\Bundle\WebBundle\Features\Context;

use Ajaxray\Behat\Context\DoctrineContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Helper\Dir;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary, DoctrineContext;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * Pauses the scenario until the user presses a key. Useful when debugging a scenario.
     *
     * @Then break
     */
    public function iPutABreakpoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while (fgets(STDIN, 1024) == '') {}
        fwrite(STDOUT, "\033[u");
        return;
    }

    /**
     * @Then /^Content inside "(?P<selector>[^"]+)" should not be same$/
     */
    public function contentShouldNotBeSameAlwaysIn($selector)
    {
        for($i = 1; $i < count($this->pages); $i++) {
            $currentContent = $this->pages[$i]->find('css', $selector)->getText();
            $previousContent = $this->pages[$i - 1]->find('css', $selector)->getText();
            //fwrite(STDOUT, "$currentContent". PHP_EOL);
            if($currentContent != $previousContent) {
                return true;
            }
        }

        throw new Exception("Found same content every time in \"$selector\"");
    }

    /**
     * @Then /^content under ajker hadis should not be same in (\d+) reloads$/
     */
    public function contentUnderAjkerHadisShouldNotBeSameInReloads($numberOf)
    {
        $selector = '#random-hadis';
        $lastContent = null;

        for($i = 0; $i < $numberOf; $i++) {
            $this->getSession()->reset();
            $this->getSession()->visit($this->getSession()->getCurrentUrl().'?cb='.microtime().rand(1, 1000));

            $content = $this->getSession()->getPage()->find('css', $selector)->getText();
            if(is_null($lastContent)) {
                $lastContent = $content;
            } else {
                if($lastContent != $content) {
                    return true;
                }
                $lastContent = $content;
            }
        }

        throw new Exception("Found same content every time in \"$selector\"");
    }

    /**
     * @When /^There are (\d+) highlighted hadis in database$/
     */
    public function thereAreHighlightedHadisInDatabase($numberOf)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $rows = $em->createQuery('SELECT COUNT(h.id) FROM IhadisCoreBundle:Hadith h WHERE h.highlighted = 1')->getSingleScalarResult();
        if($rows != $numberOf) {
            throw new \Exception("$rows rows found. Which is less then $numberOf");
        }
    }

    /**
     * @AfterScenario @javascript
     */
    public function closeBrowser()
    {
        $this->getSession()->stop();
    }

    /**
     * @When /^I mark (\d+) hadis as highlighted$/
     */
    public function iMarkHadisAsHighlighted($numberOf)
    {
        $ids = [];
        for($i = 1; $i <= $numberOf; $i++) { $ids[] = $i; }
        $ids = implode(',', $ids);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $updatedRows = $em->createQuery("UPDATE IhadisCoreBundle:Hadith h SET h.highlighted = 1 WHERE h.id IN ($ids)")
            ->execute();
        if($updatedRows != $numberOf) {
            throw new \Exception("$updatedRows updated where expected was $numberOf!");
        }
    }

    /**
     * @Given /^I am logged in as admin$/
     */
    public function iAmLoggedInAsAdmin()
    {
        $this->visit('/login');
        $this->fillField('_username', 'admin');
        $this->fillField('_password', '123456');
        $this->pressButton('Login');
    }

    /**
     * @Given /^the following Hadis books are in database$/
     */
    public function theFollowingHadisBooksAreInDatabase(TableNode $table)
    {
        $this->clearData();
        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach($table->getHash() as $bookData) {
            $book = new Book();
            $book->setTitle(trim($bookData['title']));
            $book->setCollector($bookData['collector']);
            $book->setNumberOfHadis($bookData['numberOfHadis']);
            $book->setSlug($bookData['slug']);
            $book->setPublished(boolval($bookData['published']));
            $em->persist($book);
        }
        $em->flush();
    }

}
